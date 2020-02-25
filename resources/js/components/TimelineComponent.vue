<template>
  <div>
    <div v-show="loading" class="loader"></div>
    <table v-show="!loading" class="table">
      <tr v-for="line in timelineLists" :key="line.id">
        <td>
          {{line.created_at.substring(0, 10)}}
        </td>
        <td>
          {{line.created_at.substring(11, 16)}}
        </td>
        <td>
          <a :href="`${baseUrl}/user/detail/${line.user_id}`">
            {{ line.users.name }}
          </a>
          さんが
          <a :href="`${baseUrl}/book/${line.purchases.id}`">
            {{ line.purchases.books.title }}
          </a>
          を
          {{ line.content }}
        </td>
        <td>
          <div v-if="isReactionlists[line.id] === 1" @click="pushReaction(line.id)">
            <img class="goodBtn" src="img/good1.png">
          </div>
          <div v-else-if="isReactionlists[line.id] === 2" @click="pushReaction(line.id)">
            <img class="goodBtn" src="img/loading.gif">
          </div>
          <div v-else @click="pushReaction(line.id)">
            <img class="goodBtn" src="img/good2.png">
          </div>
        </td>
        <td>
            <!-- 切り替えボタンの設定 -->
            <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#exampleModal' + line.id">
              {{ reactionUserslists[line.id].length }}
            </button>
            <div v-if="reactionUserslists[line.id].length === 0"></div>
            <!-- モーダルの設定 -->
            <div v-else class="modal fade" :id="'exampleModal' + line.id" tabindex="-1" role="dialog" :aria-labelledby="'exampleModalLabel' + line.id">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" :id="'exampleModalLabel' + line.id">いいねしたユーザー</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div v-for="(user, key) in reactionUserslists[line.id]" :key="key">
                      <p>{{ user }}</p>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                  </div><!-- /.modal-footer -->
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    login: String,  // ログインユーザーID
    name: String, // ログインユーザー名
    token: String
  },
  data() {
    return {
      loginId: parseInt(this.login),  // BladeからはStringの値しか受け取れない問題の回避
      timelineLists: [],
      isReactionlists: [],
      reactionUserslists: [],
      csrf_token: this.token,
      loading: true,
      baseUrl: process.env.MIX_REMOTE_BASE_URL
    }
  },
  methods: {
    pushReaction(lineId) {
      this.isReactionlists.splice(lineId, 1, 2) // status:2 はローディングアニメーション用

      // ログインユーザー自身が押したボタンの状態によっていいね数を更新
      axios
        .post(
          `${this.baseUrl}/timeline/reaction`,
          { timelineId: lineId },
          { headers: {'X-CSRF-TOKEN': this.csrf_token} }
        )
        .then(res => {
          let cnt = 0

          // いいね解除
          if (res.data.status === 0) {
            this.reactionUserslists.splice(lineId, 1, this.reactionUserslists[lineId].filter(username => this.name !== username)) // いいねしたユーザー欄からログインユーザーの名前を消す
          } else if (res.data.status === 1) {
            this.reactionUserslists[lineId].push(this.name) // いいねしたユーザー欄にログインユーザーの名前を追加する
          }

          // 配列内要素切り替えでのレンダリング処理はsplice()等を使わないとリアクティブに動作しない
          this.isReactionlists.splice(lineId, 1, res.data.status)
        })
    }
  },
  created() {
    axios.get(`${this.baseUrl}/timeline/json`)
    .then(response => {
      this.timelineLists = response.data
      for (const line of this.timelineLists) {
        let userList = [] // いいねしているユーザー名を入れる

        this.isReactionlists[line.id] = 0 // statusの0

        for (const reaction of line.reactions) {
          // ログインユーザーがそのレコードを1回でもいいねしたことがある場合
          if (reaction.user_id === this.loginId) {
            this.isReactionlists[line.id] = reaction.status // いいね画像(黄)を有効化
          }
          if (reaction.status === 1) {
            userList.push(reaction.users.name)
          }
        }
        this.reactionUserslists[line.id] = userList
      }
      this.loading = false  // timelineLists読み込み完了 -> ローディングアニメーション終了
    })
    .catch(error => {
      console.log(error);
    })
  },
}
</script>

<style scoped>
img {
  width: 24px;
}

.loader {
  font-size: 10px;
  margin: auto;
  position: fixed;
  top: 40%;
  left: 45%;
  text-indent: -9999em;
  width: 11em;
  height: 11em;
  border-radius: 50%;
  background: #0094ff;
  background: -moz-linear-gradient(left, #0094ff 10%, rgba(0,148,255, 0) 42%);
  background: -webkit-linear-gradient(left, #0094ff 10%, rgba(0,148,255, 0) 42%);
  background: -o-linear-gradient(left, #0094ff 10%, rgba(0,148,255, 0) 42%);
  background: -ms-linear-gradient(left, #0094ff 10%, rgba(0,148,255, 0) 42%);
  background: linear-gradient(to right, #0094ff 10%, rgba(0,148,255, 0) 42%);
  -webkit-animation: load3 1.4s infinite linear;
  animation: load3 1.4s infinite linear;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.loader:before {
  width: 50%;
  height: 50%;
  background: #0094ff;
  border-radius: 100% 0 0 0;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
}
.loader:after {
  background: #ffffff;
  width: 75%;
  height: 75%;
  border-radius: 50%;
  content: '';
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
@-webkit-keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
