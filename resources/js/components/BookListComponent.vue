<template>
  <div>
    <div v-show="loading" class="loader"></div>
    <div v-show="!loading" class="table-responsive">
      <table class="table text-nowrap">
        <thead>
          <tr>
            <th></th>
            <th>img</th>
            <th>タイトル</th>
            <th>カテゴリ</th>
            <th>追加日</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="purchase in getItems" :key="purchase.id">
            <book-component
              :purchase="purchase"
              >
            </book-component>
          </tr>
        </tbody>
      </table>
    </div>

    <paginate
      v-show="!loading"
      :pageCount="getPageCount"
      :page-range="3"
      :margin-pages="2"
      :containerClass="'pagination'"
      :page-class="'page-item'"
      :page-link-class="'page-link'"
      :prev-class="'page-item'"
      :prev-link-class="'page-link'"
      :next-class="'page-item'"
      :next-link-class="'page-link'"
      :clickHandler="clickCallback">
    </paginate>
  </div>
</template>

<script>
export default {
  props: {
    auth: String,
    login: String,  // ログインユーザーID
    csrfToken: String,
  },
  data() {
    return {
      loginId: parseInt(this.login),  // BladeからはStringの値しか受け取れない問題の回避
      purchases: [],
      loading: true,
      baseUrl: process.env.MIX_REMOTE_BASE_URL,
      parPage: 10,
      currentPage: 1
    }
  },
  methods: {
    clickCallback(pageNum) {
      this.currentPage = Number(pageNum)
    }
  },
  created() {
    axios.get(`${this.baseUrl}/${this.auth}/json`)
      .then(response => {
        this.purchases = response.data
        this.loading = false  // ローディングアニメーション終了
      })
      .catch(error => {
        console.log(error)
      })
  },
  computed: {
    getItems: function() {
      let current = this.currentPage * this.parPage
      let start = current - this.parPage
      return this.purchases.slice(start, current)
    },
    getPageCount: function() {
      return Math.ceil(this.purchases.length / this.parPage)
    }
  }

}
</script>

<style scoped>
.categoriesCol ul {
  display: flex;
  flex-wrap: wrap;
}
.categoriesCol li {
  list-style: none;
  margin-bottom: 9px;
  margin-right: 3px;
}
.categoriesCol ul li a {
  padding: 4px;
  background-color: #ddd;
  border-radius: 7px;
  color: #333;
  text-decoration: none;
}
.categoriesCol ul li a:hover {
  background-color: #fff;
  color: #888;
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
