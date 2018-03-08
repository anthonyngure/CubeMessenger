<template>
    <v-layout row wrap>
        <v-flex xs12>
            <pick-pack-map style="height: 100%; width: 100%"></pick-pack-map>
            <v-card id="sign-in-card" class="elevation-12">
                <v-toolbar dark color="primary">
                    <v-toolbar-title>Sign In</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-progress-linear v-show="connecting" :indeterminate="true"></v-progress-linear>
                    <v-alert v-model="error" type="error" dismissible icon="warning" dark>
                        {{errorText}}
                    </v-alert>
                    <v-layout>
                        <v-flex xs10 offset-xs1>
                            <v-form v-model="valid" ref="form" lazy-validation>
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
                                <v-layout mb-4>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="submit" round color="primary" :disabled="!valid || connecting">
                                        Sign In
                                    </v-btn>
                                </v-layout>
                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<style scoped>
    #sign-in-card {
        position: absolute;
        right: 15px;
        top: 85px;
        width: 30%;
    }
</style>
<script type="text/javascript">
    import PickPackMap from './PickPackMap'

    export default {
        components: {PickPackMap},
        name: 'Blank',
        data () {
            return {
                passwordVisibilityOff: true,
                valid: false,
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
        watch: {},
        methods: {
            submit () {
                if (this.$refs.form.validate()) {
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
                            let user = response.data.data
                            if (user.client) {
                                this.$vuetify.theme.primary = user.client.primaryColor
                                this.$vuetify.theme.accent = user.client.accentColor
                            }
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
    }
</script>
