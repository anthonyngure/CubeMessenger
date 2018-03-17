<template>
    <v-card v-if="connecting">
        <v-card-text>
            <v-progress-linear :indeterminate="true"></v-progress-linear>
            <p class="text-xs-center">Please wait....</p>
            <v-alert v-model="error" type="error" dismissible icon="warning" dark>
                {{errorText}}
            </v-alert>
            <p v-show="!connecting && !error">Complete</p>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn :color="error ? 'red' : 'primary'" flat v-show="!connecting || error"
                   @click.native="onCloseSubmittingDialog">
                {{error ? 'Cancel' : 'Close'}}
            </v-btn>
        </v-card-actions>
    </v-card>
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
          }).catch(error => {
          this.error = true
          this.$emit('onError', error)
          this.$utils.log(error)
        })
      }
    }
  }
</script>

<style scoped>

</style>