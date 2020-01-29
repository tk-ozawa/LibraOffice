<template>
  <fieldset>
    <legend>プロフィール編集</legend>
    <div :class="errorClassObject('name')" class="form-group">
      <label for="inputTitle" class="col-md-2 control-label">ユーザー名</label>
      <div class="col-md-10">
        <input v-model="edit.name" type="text" class="form-control" id="inputTitle" placeholder="書籍タイトル">
      </div>
    </div>
    <div :class="errorClassObject('summary')" class="form-group">
      <label for="inputSummary" class="col-md-2 control-label">サマリ</label>
      <div class="col-md-10">
        <textarea v-model="edit.summary" class="form-control" rows="3" id="inputSummary"></textarea>
      </div>
    </div>
    <div :class="errorClassObject('date')" class="form-group">
      <label for="inputRelease" class="col-md-2 control-label">発売日</label>
      <div class="col-md-10">
        <input v-model="edit.date" type="date" class="form-control" id="inputRelease">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-10 col-md-offset-2">
        <button
          @click="doSubmit"
          :disabled="isValid == false"
          type="submit"
          class="btn btn-primary center-block"
          v-if="!show"
        >Submit</button>
        <v-loading :show="show"></v-loading>
      </div>
    </div>
  </fieldset>
</template>

<script>
const dateRE   = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/

Vue.component('v-loading', {
    props: {
        show: {
            default: false,
            type: Boolean
        }
    },
    template: '<div v-if="show"><div class="loader"></div></div>'
})

export default {
  props: {
    username : String,
    profile: String,
    birthday: String,
    send_url: String,
    csrf_token: String,
  },
  data() {
    return {
      edit: {
        name: this.username,
        summary: this.profile,
        date: this.birthday
      },
      show: false
    }
  },
  computed: {
    validation() {
      const edit = this.edit
      return {
        name  : (!!edit.name),
        summary: (!!edit.summary),
        date: (!!edit.date && dateRE.test(edit.date))
      }
    },
    isValid() {
      const validation = this.validation
      return Object
        .keys(validation)
        .every((key) => {
          return validation[key]
      })
    }
  },
  methods: {
    errorClassObject(key) {
      return {
        'has-error': (this.validation[key] == false)
      }
    },
    doSubmit(e) {
      this.show = true
      axios.post(this.send_url, this.edit, {
        headers: {'X-CSRF-TOKEN': this.csrf_token}
      })
        .then(response => {
          alert('プロフィールを更新しました')
        })
        .catch(error => {
          console.log(error);
        })
        .then(() => {
          this.show = false
        })
    }
  }
}
</script>

<style>
.loader {
  color: #e3f2fd;
  font-size: 20px;
  margin: 100px auto;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  position: relative;
  text-indent: -9999em;
  -webkit-animation: load4 1.3s infinite linear;
  animation: load4 1.3s infinite linear;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
@-webkit-keyframes load4 {
  0%,
  100% {
    box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
  }
  12.5% {
    box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
  }
  25% {
    box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
  }
  37.5% {
    box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
  }
  50% {
    box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
  }
  62.5% {
    box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
  }
  75% {
    box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
  }
  87.5% {
    box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
  }
}
@keyframes load4 {
  0%,
  100% {
    box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
  }
  12.5% {
    box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
  }
  25% {
    box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
  }
  37.5% {
    box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
  }
  50% {
    box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
  }
  62.5% {
    box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
  }
  75% {
    box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
  }
  87.5% {
    box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
  }
}
</style>
