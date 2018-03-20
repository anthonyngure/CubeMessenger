<template>
    <v-dialog v-model="dialog"
              lazy
              persistent
              min-height="600px"
              max-width="500px">
        <v-card>
            <v-toolbar dense color="primary" dark>
                <v-icon class="mx-3">{{type === 'it' ? 'computer' : 'build'}}</v-icon>
                <v-toolbar-title>{{$route.name}}</v-toolbar-title>
            </v-toolbar>
            <v-card-text>

                <connection-manager ref="connectionManager"
                                    @onSuccess="onConnectionManagerSuccess"
                                    @onConnectionChange="(val)=>{connecting = val}">
                </connection-manager>

                <v-select
                        class="mb-3"
                        v-model="select"
                        :disabled="connecting"
                        :label="detailsLabel"
                        multiple
                        required
                        :rules="[() => select.length > 0 || 'You must choose at least one']"
                        :hint="detailsHint"
                        persistent-hint
                        chips
                        tags
                        :search-input.sync="search"
                        :loading="loading"
                        :items="items">
                </v-select>

                <v-text-field
                        name="note"
                        rows="2"
                        v-model="note"
                        label="Write a short note"
                        placeholder="Short note"
                        :disabled="connecting"
                        multi-line>
                </v-text-field>

                <v-alert type="info">
                    If you don't schedule, this issue will be attended to immediately
                </v-alert>
                <v-layout row wrap>
                    <v-flex xs6>
                        <date-input v-model="scheduleDate"
                                    placeholder="Schedule date"
                                    :disabled="connecting">
                        </date-input>
                    </v-flex>
                    <v-flex xs6 class="pl-3">
                        <time-input v-model="scheduleTime"
                                    placeholder="Schedule time"
                                    :disabled="connecting">
                        </time-input>
                    </v-flex>
                </v-layout>

            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" flat @click.stop="$emit('onClose')">Cancel</v-btn>
                <v-btn color="primary" :disabled="!formIsValid || connecting" @click.stop="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import DateInput from './DateInput'
  import TimeInput from './TimeInput'

  export default {
    components: {
      TimeInput,
      DateInput,
      ConnectionManager
    },
    name: 'service-request-dialog',
    props: {
      show: {
        type: Boolean,
        required: true
      },
      type: {
        type: String,
        required: true,
        validator: function (value) {
          return value === 'it' || value === 'repair'
        }
      }
    },
    computed: {
      formIsValid () {
        return this.select.length > 0
      },
      detailsHint () {
        return this.type === 'it' ? 'Hit \'Enter\' to write multiple issues or select from the suggestions, e.g Computer is slow'
          : 'Hit \'Enter\' to write multiple issues or select from the suggestions, e.g A broken chair or wall painting'
      },
      detailsLabel () {
        return this.type === 'it' ? 'What issues you have noticed' : 'What repairs do you need'
      }
    },
    watch: {
      show (val) {
        this.dialog = val
      },
      search (val) {
        val && this.querySelections(val)
      }
    },
    data () {
      return {
        dialog: false,
        connecting: false,
        serviceOptions: [],
        note: null,
        select: [],
        loading: false,
        items: [],
        search: null,
        scheduleDate: null,
        scheduleTime: null,
      }
    },
    methods: {
      onConnectionManagerSuccess (response) {
        this.$emit('onClose', true)
      },
      submit () {
        let serviceRequest = {
          scheduleDate: this.scheduleDate,
          scheduleTime: this.scheduleTime,
          note: this.note,
          type: this.type,
          details: this.select
        }

        this.$utils.log(serviceRequest)
        this.$refs.connectionManager.store('serviceRequests', serviceRequest)
      },


      querySelections (val) {
        this.loading = true
        this.axios.get('serviceRequestOptions', {
          params: {
            search: val,
            type: this.type
          }
        })
          .then(response => {
            this.items = []
            for (let item of response.data.data) {
              this.items.push(item.description)
            }
            this.loading = false
          })
          .catch(error => {
            this.loading = false
            this.$utils.log(error)
          })
        // Simulated ajax query
        /*setTimeout(() => {
          this.items = this.states.filter(e => {
            return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
          })
          this.loading = false
        }, 500)*/
      }
    },
    mounted () {
      //this.$refs.connectionManager.connecting = true
    }
  }
</script>

<style scoped>

</style>