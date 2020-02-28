<template>
  <div class="row">
    <div class="col-2 btn-col">
      <div v-if="loading" class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
      <button v-else-if="purchase" class="btn btn-danger" @click="clickReturn()">返却する</button>
    </div>
    <div class="col-3">
      <a :href="`${$parent.baseUrl}/book/${purchase.id}`">
        <img :src="purchase.books.img_url">
      </a>
    </div>
    <div class="col-2">
      <a :href="`${$parent.baseUrl}/book/${purchase.id}`">
        {{purchase.books.title}}
      </a>
    </div>
    <div class="col-4 categoriesCol">
      <ul>
        <li v-for="(category) in purchase.books.categories" :key="category.id">
            <a :href="`${$parent.baseUrl}/book/find/category/${category.name}`">
              {{category.name}}
            </a>
        </li>
      </ul>
    </div>
    <div class="col-1">
      <p>
        {{purchase.purchase_date}}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    purchase: Object,
  },
  data() {
    return {
      loginId: parseInt(this.$parent.login),  // BladeからはStringの値しか受け取れない問題の回避
      loading: false,
    }
  },
  methods: {
    clickReturn() {
      let res = confirm(`返却しますか？:${this.purchase.books.title}`)

      // OKなら移動
      if (res === true) {
        this.loading = true
        axios
          .post(
              `${this.$parent.baseUrl}/book/${this.purchase.id}/return`, null
            )
          .then(res => {
            this.$parent.getItems.splice(this.$parent.key, 1)
          })
          .catch(err => console.error(err))
          .finally(() => this.loading = false)
      }
    },
    clickCallback(pageNum) {
      this.currentPage = Number(pageNum)
    }
  },
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
.btn-col {
  text-align: center;
}

.spinner {
  margin: 10px auto 0;
  width: 70px;
}

.spinner > div {
  width: 18px;
  height: 18px;
  background-color: #00c9e8;

  border-radius: 100%;
  display: inline-block;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0) }
  40% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% {
    -webkit-transform: scale(0);
    transform: scale(0);
  } 40% {
    -webkit-transform: scale(1.0);
    transform: scale(1.0);
  }
}
</style>
