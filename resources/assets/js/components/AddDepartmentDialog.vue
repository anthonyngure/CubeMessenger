<template>
    <v-dialog v-model="dialog" lazy max-width="400px" persistent>
        <v-card>
            <v-toolbar dark card color="primary">
                <v-icon>group_work</v-icon>
                <v-toolbar-title>Add Department</v-toolbar-title>
            </v-toolbar>

            <connection-manager ref="connectionManager" v-model="connecting"></connection-manager>

            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field
                                placeholder="Department name"
                                label="Enter department name"
                                required
                                v-model="departmentName">
                        </v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" flat @click="$emit('onClose', false)">Cancel</v-btn>
                <v-btn color="primary" :disabled="connecting || !departmentName" @click="submit">Add Department</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
  import ConnectionManager from './ConnectionManager'

  export default {
    name: 'AddDepartmentDialog',
    components: {ConnectionManager},
    props: {
      addingDepartment: {
        type: Boolean,
        required: true
      }
    },
    data () {
      return {
        dialog: false,
        connecting: false,
        departmentName: null,
      }
    },
    watch: {
      addingDepartment (val) {
        this.dialog = !!val
      }
    },
    methods: {
      submit () {
        let that = this
        this.$refs.connectionManager.post('departments', {
          onSuccess (response) {
            that.departmentName = null
            that.$emit('onClose', true)
          }
        }, {
          name: this.departmentName,
        })
      }
    }
  }
</script>

<style scoped>

</style>