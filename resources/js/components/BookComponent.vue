<template>
  <div>
    <td class="btnCol">
      <button v-if="purchase.rentals && purchase.rentals.user_id === loginId" class="btn btn-danger" @click="clickReturn(purchase.id, purchase.books.title)">返却する</button>
      <button v-if="purchase.rentals && purchase.rentals.user_id !== loginId" class="btn btn-warning">貸出中</button>
      <button v-show="!purchase.rentals" class="btn btn-primary" @click="clickRental(purchase.id, purchase.books.title)">貸出する</button>
    </td>
    <td>
      <a :href="`${$parent.baseUrl}/book/${purchase.id}`">
        <img :src="purchase.books.img_url">
      </a>
    </td>
    <td>
      <a :href="`${$parent.baseUrl}/book/${purchase.id}`">
        {{purchase.books.title}}
      </a>
    </td>
    <td class="categoriesCol">
      <ul>
        <li v-for="(category) in purchase.books.categories" :key="category.id">
            <a :href="`${$parent.baseUrl}/book/find/category/${category.name}`">
              {{category.name}}
            </a>
        </li>
      </ul>
    </td>
    <td>
      <p>
        {{purchase.purchase_date}}
      </p>
    </td>
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
    }
  },
  methods: {
    clickRental(purchaseId, bookTitle) {
      let res = confirm(`貸出申請しますか？${purchaseId}:${bookTitle}`)

      // OKなら移動
      if (res === true) {
        axios
          .post(
              `${this.$parent.baseUrl}/book/${purchaseId}/rental`, null
            )
          .then(res => {
            let rentals = res.data.rentals
            // 申請中に貸出されていた場合
            if (rentals.user_id !== this.loginId) {
              alert(`"${this.purchase.books.title}"は貸出中でした。`)
            } else {  // 貸出申請成功
              alert(`"${this.purchase.books.title}"の貸出申請を提出しました。`)
            }
            this.purchase.rentals = rentals // リアクティブに動いた！
          })
      }
    },
    clickReturn(purchaseId, bookTitle) {
      let res = confirm(`返却しますか？${purchaseId}:${bookTitle}`)

      // OKなら移動
      if (res === true) {
        // window.location.href = `${this.$parent.baseUrl}/book/${purchaseId}/return`
        axios
          .post(
              `${this.$parent.baseUrl}/book/${purchaseId}/return`, null
            )
          .then(res => {
            let rentals = res.data.rentals
            alert(`"${this.purchase.books.title}"を返却しました。`)
            this.purchase.rentals = rentals // リアクティブに動いた！
          })
      }
    },
    clickCallback(pageNum) {
      this.currentPage = Number(pageNum)
    }
  },
  created() {
    // console.log(this.purchase)
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

.btnCol {
  text-align: center;
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
