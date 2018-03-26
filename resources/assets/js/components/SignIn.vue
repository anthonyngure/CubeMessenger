<template>
    <v-layout row wrap align-center justify-center>
        <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
                <v-toolbar color="white" dense>
                    <img :src="'/img/logo.png'" height="36px" width="200px" class="mr-3"/>
                    <v-icon color="primary">person</v-icon>
                    <v-toolbar-title>Sign In</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-progress-linear v-show="connecting" :indeterminate="true"></v-progress-linear>
                    <v-alert v-model="error" type="error" dismissible icon="warning" dark>
                        {{errorText}}
                    </v-alert>
                    <v-text-field
                            :disabled="connecting"
                            id="username"
                            name="username"
                            :rules="emailRules"
                            type="email"
                            label="Enter your email address"
                            v-model="email"
                            prepend-icon="email"
                            required>
                    </v-text-field>
                    <v-text-field
                            :disabled="connecting"
                            name="password"
                            label="Enter your password"
                            v-model="password"
                            :rules="passwordRules"
                            required
                            prepend-icon="vpn_key"
                            :append-icon="passwordVisibilityOff ? 'visibility' : 'visibility_off'"
                            :append-icon-cb="() => (passwordVisibilityOff = !passwordVisibilityOff)"
                            :type="passwordVisibilityOff ? 'password' : 'text'">
                    </v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-btn @click="submit" round color="primary" :disabled="!valid || connecting">
                        Sign In
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<style scoped>
    /*#sign-in-card {
        position: absolute;
        right: 15px;
        top: 85px;
        width: 30%;
    }*/
</style>
<script type="text/javascript">

  export default {
    name: 'Blank',
    data () {
      return {
        passwordVisibilityOff: true,
        error: null,
        errorText: '',
        email: '',
        emailRules: [
          (v) => !!v || 'Username is required'
        ],
        password: '',
        passwordRules: [
          (v) => !!v || 'Password is required'
        ],
        connecting: false
      }
    },
    computed: {
      valid () {
        return this.email && this.password
      }
    },
    methods: {
      submit () {
        // Native form submission is not yet supported
        this.error = false
        this.connecting = true
        this.$auth.login({
          data: {
            signInId: this.email,
            password: this.password
          },
          rememberMe: true,
          success (response) {
            this.$utils.log(response.data.data)
            this.connecting = false
          },
          error (error) {
            this.error = true
            this.connecting = false
            this.errorText = 'An error occurred ' + error.message
          }
        })
      }
    }
  }
</script>
