<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <colgroup>
                <col width="20%">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th>문장</th>
                <td>
                    <input type="text" name="sentence" value="{{ $sentence->sentence }}" class="form-control @error('sentence') is-invalid @enderror">
                    @error('sentence')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th>번역</th>
                <td>
                    <input type="text" name="sentence_ko" value="{{ $sentence->sentence_ko }}" class="form-control">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.sentences', $sentence) }}" class="btn btn-secondary">뒤로</a>
            <div>
                @if($sentence->id)
                    <a href="{{ route('admin.sentences.destroy', $sentence) }}" class="btn btn-danger" x-data="" @click.prevent="deleteSentence">삭제</a>
                <script>
                    function deleteSentence(){
                      var href = event.target.href;

                      if(!confirm('삭제 하시겠습니까?')){
                        return false;
                      }

                      axios.delete(href).then(function(res){
                        if(res.status == 200){
                          alert('삭제 되었습니다.');
                          window.location.href= res.data;
                        }
                      });
                    }
                </script>
                @endif
                <input type="submit" value="저장" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>