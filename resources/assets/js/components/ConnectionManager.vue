<template >
  <v-card flat
          v-if="connecting || error" >
    <v-card-text >
      <v-progress-linear v-if="connecting"
                         :indeterminate="true"/>
      <p v-if="connecting"
         class="text-xs-center" >Please wait....</p >
      <v-alert v-model="error"
               type="error"
               icon="warning"
               dark >
        {{errorText}}
      </v-alert >
      <p v-show="!connecting && !error" >Complete</p >
    </v-card-text >
  </v-card >
</template >

<script >
export default {
  name: 'connection-manager',
  data () {
    return {
      connecting: false,
      error: false,
      errorText: null,
      dialog: false
    }
  },
  watch: {
    connecting (val) {
      this.$utils.log(val)
      this.$emit('input', this.connecting)
    }
  },
  methods: {
    
    reset(){
      this.connecting = false
      this.error = false
      this.errorText = null
    },
    
    onFailure (error, callbacks) {
      this.error = true
      this.connecting = false
      if (callbacks && callbacks.onFailure) {
        callbacks.onFailure(error)
      }
      this.$utils.log(error)
      if (error.response) {
        if (error.response.status === 422) {
          switch (error.response.data.meta.code) {
            case 'VALIDATION':
              this.errorText = error.response.data.data
              break
            default:
              this.errorText = error.response.data.meta.message
          }
        } else if (error.response.data.message) {
          this.errorText = error.response.data.message
        } else {
          this.errorText = error.response.data
        }
      }
    },
    onSuccess (response, callbacks) {
      this.connecting = false
      this.error = false
      this.errorText = null
      this.$utils.log(response)
      if (callbacks && callbacks.onSuccess) {
        callbacks.onSuccess(response)
      }
    },
    
    post (relativePath, callbacks, body) {
      this.connecting = true
      this.error = false
      this.axios.post(relativePath, body)
        .then(response => {
          this.onSuccess(response, callbacks)
        })
        .catch(error => {
          this.onFailure(error, callbacks)
        })
    },
    get (relativePath, callbacks, params) {
      this.$utils.log(relativePath)
      this.$utils.log(params)
      this.connecting = true
      this.error = false
      this.axios.get(relativePath, {params: params})
        .then(response => {
          this.onSuccess(response, callbacks)
        })
        .catch(error => {
          this.onFailure(error, callbacks)
        })
    },
    
    patch (relativePath, callbacks, data) {
      this.$utils.log(relativePath)
      this.$utils.log(data)
      this.connecting = true
      this.error = false
      this.axios.patch(relativePath, data)
        .then(response => {
          this.onSuccess(response, callbacks)
        })
        .catch(error => {
          this.onFailure(error, callbacks)
        })
    },
    
    delete (relativePath, callbacks) {
      this.$utils.log(relativePath)
      this.connecting = true
      this.error = false
      this.axios.delete(relativePath)
        .then(response => {
          this.onSuccess(response, callbacks)
        })
        .catch(error => {
          this.onFailure(error, callbacks)
        })
    }
  }
}
</script >

<style scoped >

</style >