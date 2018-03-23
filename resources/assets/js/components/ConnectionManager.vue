<template>
    <div v-if="connecting || error">
        <v-progress-linear v-if="connecting" :indeterminate="true"></v-progress-linear>
        <p v-if="connecting" class="text-xs-center">Please wait....</p>
        <v-alert v-model="error" type="error" icon="warning" dark>
            {{errorText}}
        </v-alert>
        <p v-show="!connecting && !error">Complete</p>
    </div>
</template>

<script>
  export default {
    name: 'connection-manager',
    data () {
      return {
        connecting: false,
        error: false,
        errorText: null,
      }
    },
    watch: {
      connecting (connecting) {
        this.$emit('onConnectionChange', connecting)
      }
    },
    methods: {
      onCloseSubmittingDialog () {
        this.connecting = false
        this.$emit('onCancel')
      },
      store (relativePath, body) {
        this.connecting = true
        this.axios.post(relativePath, body)
          .then(response => {
            this.error = false
            this.connecting = false
            this.$emit('onSuccess', response)
            this.$utils.log(response)
          }).catch(error => {
          this.error = true
          this.$emit('onError', error)
          this.$utils.log(error)
        })
      },
      index (relativePath, params) {
        this.connecting = true
        this.axios.get(relativePath, {
          params: params
        })
          .then(response => {
            this.error = false
            this.connecting = false
            this.$emit('onSuccess', response)
            this.$utils.log(response)
          })
          .catch(error => {
            if (error.response) {
              this.errorText = error.response.data.meta.message
            }
            this.error = true
            this.$emit('onError', error)
            this.$utils.log(error)
          })
      },

      onFailure (error, callbacks) {
        this.error = true
        this.connecting = false
        if (callbacks && callbacks.onFailure) {
          callbacks.onFailure(error)
        }
        this.$utils.log(error)
        if (error.response) {
          this.errorText = error.response.data.data
        }
        /*if (error.response && error.status === 422) {
          this.errorText = error.response.data.data
        } else if (error.response) {
          this.errorText = error.response.data.meta.message
        }*/
      },

      onSuccess (response, callbacks) {
        this.error = false
        this.connecting = false
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
    }
  }
</script>

<style scoped>

</style>