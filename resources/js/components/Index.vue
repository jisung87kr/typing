<script>
export default {
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
      this.isLast = this.sentences.length <= this.index;

      if(this.isLast){
        alert('마지막입니다.');
        return false;
      }

      this.index = this.isLast ? this.sentences.length : this.index + 1;
      this.getCurrentSentence();
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
      item[0].done = false;
      item[0].sentenceArray = [];
      for (let i = 0; i < item[0].sentence.length; i++) {
        let alphabet = {
          'alphabet': item[0].sentence[i],
          'input': null,
          'correct': null,
        };
        item[0].sentenceArray.push(alphabet);
      }

      this.currentSentence = item[0];
    },
    typing(){
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
    wrapFragments(){

    }
  }
}
</script>

<template>
  <div class="container">
    <h1 class="my-3 sentence clearfix"
        :class="isTyping ? 'is-typing' : ''"
        @click="focusInput">
      <span v-for="(item, i) in currentSentence.sentenceArray"
            class="fragment float-start"
            ref="listItem"
            :key="i"
            :class="[
              (item.correct === false) ? 'error' : '',
              (item.correct === true) ? 'success' : '',
              (i == text.length) ? 'active' : '',
              `item_${i}`
            ]">{{ printfragment(item.alphabet) }}</span>
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
          <span v-for="value in item.sentenceArray" v-if="item.done" v-bind:class="[
            (value.correct === false) ? 'error' : '',
            (value.correct === true) ? 'success' : '',
          ]">{{ value.alphabet }}</span>
          <span v-for="value in item.sentence" v-if="!item.done">{{ value }}</span>
        </div>
        <span class="badge rounded-pill"
              :class="item.result.perfect ? 'bg-primary' : 'bg-danger'"
              v-if="item.done">{{ item.result.perfect ? 'pass' : 'fail' }}</span>
      </li>
    </ul>
  </div>
</template>

<style scoped>
@keyframes blink-effect {
  50% {
    opacity: 0;
  }
}
.sentence{
  color: #a5a5a9;
  cursor: pointer;
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