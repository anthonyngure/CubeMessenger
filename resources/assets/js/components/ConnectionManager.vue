<template>
    <v-dialog v-model="connecting"
              max-width="350px"
              lazy persistent>
        <v-card>
            <v-card-text>
                <v-progress-linear v-show="connecting" :indeterminate="true"></v-progress-linear>
                <p v-show="connecting" class="text-xs-center">Please wait....</p>
                <v-alert v-model="error" type="error" dismissible icon="warning" dark>
                    {{errorText}}
                </v-alert>
                <p v-show="!connecting && !error">Complete</p>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :color="error ? 'red' : 'primary'" flat v-show="!connecting"
                       @click.native="onCloseSubmittingDialog">
                    {{error ? 'Cancel' : 'Close'}}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
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
      connecting(connecting){
        this.$emit('onConnectionChange', connecting)
      }
    },
    methods: {
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
      }
    }
  }
</script>

<style scoped>

</style>