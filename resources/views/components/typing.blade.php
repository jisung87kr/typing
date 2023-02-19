<div id="typing">
    <div class="card my-5">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                     현재속도 : @{{ wpm }}
                </div>
                <div class="col-auto">
                    평균속도 : @{{ avgWpm }}
                </div>
                <div class="col-auto">
                    진행 : @{{ index }} / @{{ sentences.length }}
                </div>
            </div>
        </div>
    </div>
    <h1 class="my-5 sentence clearfix"
        :class="isTyping ? 'is-typing' : ''"
        @click="focusInput">
      <span v-for="(word, idx) in currentSentence.words" class="fragment_wrapper float-start clearfix">
        <span v-for="(item, i) in word.fragments"
              class="fragment float-start"
              ref="listItem"
              :key="i"
              :class="[
                (currentSentence.sentenceArray[i + word.prevWordsLength].correct === false) ? 'error' : '',
                (currentSentence.sentenceArray[i + word.prevWordsLength].correct === true) ? 'success' : '',
                (i + word.prevWordsLength == text.length) ? 'active' : '',
                `item_${i}`
              ]">@{{ printfragment(item.alphabet) }}</span>
      </span>
    </h1>
    <div>
        <input type="text"
               v-model="text"
               @keyup="typing"
               @keydown="remove"
               @keyup.enter="next"
               @blur="blur"
               class="form-control my-3 visually-hidden"
               ref="input">
    </div>
    <ul class="list-group">
        <li v-for="(item, i) in this.sentences"
            :class="[
                    item.done ? 'done' : '',
                    i === this.index ? 'active' : '',
                    ]"
            class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                  <span v-for="value in item.sentenceArray"
                        v-if="item.done"
                        :class="[
                        (value.correct === false) ? 'error' : '',
                        (value.correct === true) ? 'success' : '',
                        ]">@{{ value.alphabet }}</span>
                <span v-for="value in item.sentence" v-if="!item.done">@{{ value }}</span>
                <small class="d-block mt-3">"@{{ item.sentence_ko }}"</small>
            </div>
            <span class="badge rounded-pill ms-2"
                  :class="item.result.perfect ? 'bg-primary' : 'bg-danger'"
                  v-if="item.done">@{{ item.result.perfect ? 'pass' : 'fail' }}</span>
        </li>
    </ul>
</div>
<style>
    @keyframes blink-effect {
        50% {
            opacity: 0;
        }
    }
    .sentence{
        color: #a5a5a9;
        cursor: pointer;
        word-break: keep-all;
    }
    .error{
        color: #ff5a5a;
    }
    .success{
        color: #333;
    }
    .done{
        background: #f4f4f4;
    }
    .fragment{
        position: relative;
    }
    .fragment.active:after{
        content:'';
        display: block;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 1px;
        height: 100%;
        background-color: #333;
        transition: 0.5s;
        animation: blink-effect 1s step-end infinite;
        display: none;
    }
    .sentence.is-typing .fragment.active:after{
        display: block;
    }
</style>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script type="module">
  const { createApp } = Vue
  const app = Vue.createApp({
    data() {
      return {
        text: [],
        index: 0,
        sentences: {},
        currentSentence: {},
        start: '',
        end: '',
        isFirst: true,
        isLast: false,
        isTyping: false,
        isFirstTyping: true,
        started_at: null,
        finished_at: null,
        wpm: 0,
        avgWpm: 0,
      }
    },
    mounted() {
      this.fetchItems();
    },
    methods:{
      fetchItems(){
        axios.get('/api/sentences').then(res => {
          if(res.data){
            this.sentences = res.data;
            this.getCurrentSentence();
            this.focusInput();
          }
        });
      },
      prev(){
        this.isFirst = this.index - 1 < 0;

        if(this.isFirst){
          alert('처음입니다.');
          return false;
        }

        this.index = this.isFirst ? 0 : this.index - 1;
        this.getCurrentSentence();
      },
      next(){
        this.currentSentence.finished_at = new Date();
        this.currentSentence.difftime = this.currentSentence.finished_at - this.currentSentence.started_at;
        this.isFirstTyping = true;
        this.currentSentence.wpm = this.calculateTypingSpeed(this.currentSentence.started_at, this.currentSentence.finished_at);
        this.avgCalculateTypingSpeed();

        this.isLast = this.sentences.length <= this.index;

        if(this.index == this.sentences.length -1 ){
          this.started_at = this.sentences[0].started_at;
          this.finished_at = this.currentSentence.finished_at;
        }

        if(this.isLast){
          alert('마지막입니다.');
          console.log(this.started_at, this.finished_at);
          return false;
        }

        this.index = this.isLast ? this.sentences.length : this.index + 1;
        this.getCurrentSentence(this.currentSentence.started_at, this.currentSentence.finished_at);
        this.wpm = 0;
      },
      getTypingResult(currentSentence){
        console.log(currentSentence);
        let result = {
          "length": currentSentence.sentenceArray.length,
          "correct": null,
          "wrong": null,
          "perfect": null,
        }
        for (let i = 0; i < currentSentence.sentenceArray.length; i++) {
          if(currentSentence.sentenceArray[i].alphabet === this.text[i]){
            result.correct++;
          } else {
            result.wrong++;
          }
        }

        result.perfect = result.correct == result.length ? true : false;
        return result;
      },
      getCurrentSentence(){
        // 초기화
        if(this.currentSentence.sentence){
          for (let i = 0; i < this.sentences.length; i++) {
            if(this.sentences[i].id == this.currentSentence.id){

              // 미입력된 항목 처리
              for (let j = this.currentSentence.sentenceArray.length-1; j > 0; j--) {
                if(this.text.length > j){
                  continue;
                }
                this.currentSentence.sentenceArray[j].correct = false;
              }

              this.sentences[i] = this.currentSentence;
              this.sentences[i].done = true;

              //
              this.sentences[i].result = this.getTypingResult(this.sentences[i]);
              console.log(this.sentences);
            }
          }
        }

        this.text = [];

        // 현재 아이템 조회
        let item = this.sentences.filter( (item, i) => {
          return i == this.index
        });

        // 데이터 준비
        this.currentSentence = this.makeFragments(item[0]);
        console.log(this.sentences);
      },
      makeFragments(item) {
        item.done = false;
        item.sentenceArray = [];
        item.words = [];

        // 공백뒤에 '␣' 추가, 공백으로 문자열을 배열로 변환
        let words = item.sentence.replace(/\s/g, ' ␣');
        words = words.split(' ');
        let prevWordLength = 0;

        // 단어별로 그루핑 (표기용 정보)
        for (let i = 0; i < words.length; i++) {
          let word = {
            'text': words[i],
            'fragments': [],
            'prevWordsLength': prevWordLength,
          };

          // 현재 문자의 인덱스 확인을 위해 이전 단어들의 길이의 합 저장
          prevWordLength += words[i].length;

          // 단어에 해당하는 문자 배열처리
          for (let j = 0; j < word.text.length; j++) {
            let alphabet = {
              'alphabet': word.text[j],
              'input': null,
              'correct': null,
            }
            word.fragments.push(alphabet);
          }

          item.words.push(word);
        }

        // 실제로 문자열 비교하는 정보
        // 데이터 비교는 item.sentenceArray
        // 입력대상 출력문자는 item.words
        for (let i = 0; i < item.sentence.length; i++) {
          let alphabet = {
            'alphabet': item.sentence[i],
            'input': null,
            'correct': null,
          };
          item.sentenceArray.push(alphabet);
        }

        return item;
      },
      typing(){
        // 초과입력 방지
        if(this.text.length > this.currentSentence.sentenceArray.length){
          return false;
        }

        // 타이핑 시작 확인
        if(this.isFirstTyping){
          this.currentSentence.started_at = new Date();
          this.isFirstTyping = false;
        }

        this.wpm = this.calculateTypingSpeed(this.currentSentence.started_at, new Date());

        // 백스페이스입력시 값 초기화
        this.remove();

        // 문자가 일치하는지 체크
        for(let i = 0; i < this.text.length; i++){
          this.currentSentence.sentenceArray[i].input = this.text[i];
          if(this.currentSentence.sentenceArray[i].alphabet != this.currentSentence.sentenceArray[i].input){
            this.currentSentence.sentenceArray[i].correct = false;
          } else {
            this.currentSentence.sentenceArray[i].correct = true;
          }
        }
      },
      focusInput(){
        this.$refs.input.focus();
        this.isTyping = true;
      },
      remove(){
        if(event.key == 'Backspace'){
          if(this.text.length == 0){
            for (let i = 0; i < this.currentSentence.sentenceArray.length; i++) {
              this.currentSentence.sentenceArray[i].input = null;
              this.currentSentence.sentenceArray[i].correct = null;
            }
          } else {
            this.currentSentence.sentenceArray[this.text.length].input = null;
            this.currentSentence.sentenceArray[this.text.length].correct = null;
          }
        }
      },
      printfragment(flag){
        return flag === ' ' ? '␣' : flag;
      },
      blur(){
        this.isTyping = false;
      },
      calculateTypingSpeed(started_at, finished_at){
        const inputText = this.text.trim();
        const wordsTyped = inputText.split(" ");
        const totalTimeInSeconds = (finished_at - started_at) / 1000;
        return Math.round((wordsTyped.length / totalTimeInSeconds) * 60);
      },
      avgCalculateTypingSpeed(){
        let cnt = 0;
        let wpmSum = 0;
        for (let i = 0; i < this.sentences.length; i++) {
          if(this.sentences[i].wpm){
            cnt++;
            wpmSum += this.sentences[i].wpm;
          }
        }

        this.avgWpm = Math.round(wpmSum / cnt);
      }
    }
  }).mount('#typing')

</script>