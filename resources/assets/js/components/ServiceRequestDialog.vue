<template>
    <v-dialog v-model="dialog"
              lazy
              persistent
              max-width="500px">
        <v-card>
            <v-card-text>

                <v-select
                        class="mb-3"
                        v-model="select"
                        label="What issues you have noticed"
                        multiple
                        required
                        :rules="[() => select.length > 0 || 'You must choose at least one']"
                        hint="Hit 'Enter' to write multiple issues or select from the suggestions, e.g Computer is slow"
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
                        multi-line>
                </v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" flat @click.stop="$emit('onClose')">Cancel</v-btn>
                <v-btn color="primary" @click.stop="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import ConnectionManager from './ConnectionManager'

  export default {
    components: {ConnectionManager},
    name: 'service-request-dialog',
    props: {
      show: {
        type: Boolean,
        required: true
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
        serviceOptions: [],
        note: null,
        select: [],
        loading: false,
        items: [],
        search: null,
      }
    },
    methods: {
      submit () {

      },
      querySelections (v) {
        this.loading = true
        this.axios.get('serviceRequestOptions', {
          params: {
            search: v
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