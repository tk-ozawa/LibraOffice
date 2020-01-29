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
          type="submit" class="btn btn-primary center-block">Submit</button>
      </div>
    </div>
  </fieldset>
</template>

<script>
const dateRE   = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/

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
      }
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
        .every(function (key) {
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
      axios.post(this.send_url, this.edit, {
        headers: {'X-CSRF-TOKEN': this.csrf_token}
      })
        .then(response => {
          alert('プロフィールを更新しました')
        }).catch(error => {
          console.log(error);
        });
    }
  }
}
</script>

<style>


</style>
