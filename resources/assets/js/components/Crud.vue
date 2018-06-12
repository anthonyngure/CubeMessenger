<template>
    <div>
        <v-dialog v-model="editDialog"
                  max-width="600px"
                  persistent>
            <v-card>
                <v-toolbar card
                           color="primary"
                           dark>
                    <v-toolbar-title>
                        {{ formTitle }}
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-container grid-list-md>
                        <connection-manager ref="editConnectionManager"
                                            v-model="connecting">
                        </connection-manager>
                        <v-form ref="form"
                                v-model="valid"
                                lazy-validation>
                            <v-layout row
                                      wrap>
                                <v-flex xs12
                                        v-for="(header, index) in headers"
                                        :key="index"
                                        v-if="isEditable(header)">

                                    <v-select v-if="header.type === 'select'"
                                              :items="toOptions(header.options)"
                                              :placeholder="toPlaceholder(header.text)"
                                              :label="header.text"
                                              :hint="itemToEditIndex > -1 ? header.editHint : header.createHint"
                                              persistent-hint
                                              :required="isRequired(header)"
                                              :rules="isRequired(header) ? [rules.required] : []"
                                              v-model="itemToEdit[header.value]"
                                              :disabled="connecting">
                                    </v-select>
                                    <crud-remote-select v-else-if="header.type === 'select_remote'"
                                                        :header="header"
                                                        :editing="itemToEditIndex > -1"
                                                        :disabled="connecting"
                                                        :required="isRequired(header)"
                                                        v-model="itemToEdit[header.value]">
                                    </crud-remote-select>
                                    <v-text-field v-else
                                                  :placeholder="toPlaceholder(header.text)"
                                                  :label="header.text"
                                                  :type="header.type"
                                                  :mask="header.mask"
                                                  :required="isRequired(header)"
                                                  :rules="isRequired(header) ? [rules.required] : []"
                                                  :hint="itemToEditIndex > -1 ? header.editHint : header.createHint"
                                                  persistent-hint
                                                  :disabled="connecting"
                                                  v-model="itemToEdit[header.value]">
                                    </v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn color="red darken-1"
                           flat
                           :disabled="connecting"
                           @click.native="close">Cancel
                    </v-btn>
                    <v-btn color="primary darken-1"
                           flat
                           :disabled="connecting || !valid"
                           @click.native="save">Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="viewDialog"
                  max-width="600px">
            <v-card v-if="itemToView">
                <v-card-text>
                    <v-data-table
                            hide-headers
                            hide-actions
                            :headers="viewItemHeaders"
                            :items="viewableHeaders">
                        <template slot="items"
                                  slot-scope="props">
                            <td>{{props.item.text}}</td>
                            <td>{{manager.toValue(props.item, itemToView)}}</td>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1"
                           flat
                           @click.native="itemToView = null">Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="deleteDialog"
                  max-width="500px"
                  persistent>
            <v-card v-if="itemToDelete">
                <v-card-text>
                    <connection-manager ref="deleteConnectionManager"
                                        v-model="deleting">
                    </connection-manager>

                    <p>Confirm you want to delete </p><b>{{manager.nameOnDelete(itemToDelete)}}</b>

                </v-card-text>

                <v-card-actions>
                    <v-spacer/>
                    <v-btn color="red"
                           flat
                           :disabled="deleting"
                           @click.native="doDelete">Delete
                    </v-btn>
                    <v-btn color="primary"
                           flat
                           :disabled="deleting"
                           @click.native="itemToDelete = null">Cancel
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <connection-manager ref="connectionManager"
                            v-model="connecting">
        </connection-manager>

        <v-card flat
                tile>
            <v-toolbar color="transparent"
                       dense
                       flat
                       card>
                <v-btn color="primary"
                       class="mx-5"
                       v-if="creatable"
                       @click.native="editDialog = true">
                    Add
                </v-btn>
                <v-btn color="primary"
                       class="mx-5"
                       v-for="(action, index) in extraTopActions"
                       :key="index"
                       v-if="manager.showTopAction(action, items, currentFilter)"
                       @click.native="manager.onTopAction(action, items, currentFilter)">
                    {{action.name}}
                </v-btn>
                <v-text-field
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                        v-model="search">
                </v-text-field>
                <v-menu
                        transition="slide-y-transition"
                        bottom
                        offset-y>
                    <v-btn slot="activator"
                           color="primary"
                           dark
                           flat
                           v-if="filters && filters.length"
                           class="purple">
                        {{currentFilter ? currentFilter.name : 'Filters'}}
                        <v-icon right>keyboard_arrow_down</v-icon>
                    </v-btn>
                    <v-list>
                        <v-list-tile v-for="(filter, i) in filters"
                                     :key="i"
                                     @click="currentFilter = filter">
                            <v-list-tile-title>{{ filter.name }}</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar>

            <v-data-table
                    :headers="browsableHeaders"
                    :items="items"
                    item-key="id"
                    :search="search"
                    expand
                    :no-data-text="connecting ? '' : 'No data available'"
                    :rows-per-page-items="rowsPerPageItems"
                    :pagination.sync="pagination"
                    class="elevation-1">
                <template slot="items"
                          slot-scope="props">
                    <tr @click="extraInlineActions.length ? props.expanded = !props.expanded : ''">
                        <td class="text-xs-left"
                            v-for="(header,index) in browsableHeaders"
                            :key="index"
                            v-if="header.value !== 'actions' ">
                            {{ manager.toValue(header, props.item) }}
                        </td>
                        <td class="justify-center layout wrap px-0">
                            <v-btn icon
                                   class="mx-0"
                                   @click="viewItem(props.item)">
                                <v-icon color="primary">visibility</v-icon>
                            </v-btn>
                            <v-btn icon
                                   class="mx-0"
                                   v-if="manager.editable(props.item)"
                                   @click="editItem(props.item)">
                                <v-icon color="success">edit</v-icon>
                            </v-btn>
                            <v-btn icon
                                   class="mx-0"
                                   v-if="manager.deletable(props.item)"
                                   @click="deleteItem(props.item)">
                                <v-icon color="red">delete</v-icon>
                            </v-btn>

                            <v-menu offset-y
                                    bottom>
                                <v-btn icon
                                       v-if="extraOverflowActions.length"
                                       slot="activator">
                                    <v-icon>more_vert</v-icon>
                                </v-btn>
                                <v-list dense>
                                    <v-list-tile v-for="(action, index) in extraOverflowActions"
                                                 :key="index">
                                        {{action.name}}
                                    </v-list-tile>
                                </v-list>
                            </v-menu>

                        </td>
                    </tr>
                </template>
                <template slot="expand"
                          slot-scope="props">
                    <v-card flat>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn v-for="(action, index) in manager.extraOverflowActions"
                                   :color="action.color"
                                   class="ml-0 mr-1"
                                   small
                                   :key="index">
                                {{action.name}}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-data-table>
        </v-card>

    </div>
</template>

<script>
  import ConnectionManager from './ConnectionManager'
  import CrudRemoteSelect from './CrudRemoteSelect'

  export default {
    name: 'Crud',
    components: {CrudRemoteSelect, ConnectionManager},
    props: {
      resource: {
        type: String,
        required: true
      },
      extraTopActions: {
        type: Array,
        required: false,
        default: function () {
          return []
        }
      },
      extraInlineActions: {
        type: Array,
        required: false,
        default: function () {
          return []
        }
      },
      extraOverflowActions: {
        type: Array,
        required: false,
        default: function () {
          return []
        }
      },
      filters: {
        type: Array,
        required: false
      },
      customViewDialog: {
        type: Boolean,
        required: false
      },
      creatable: {
        type: Boolean,
        required: false,
        default: true
      },
      manager: {
        type: Object,
        required: true
      }
    },
    data: () => ({
      editDialog: false,
      viewDialog: false,
      deleteDialog: false,
      valid: false,
      connecting: false,
      deleting: false,
      headers: [],
      browsableHeaders: [],
      viewableHeaders: [],
      viewItemHeaders: [
        {
          text: 'Name',
          value: 'name',
          align: 'left'
        },
        {
          text: 'Value',
          value: 'value',
          align: 'left'
        }
      ],
      rowsPerPageItems: [10],
      pagination: {
        rowsPerPage: 10
      },
      items: [],
      rules: {
        required: (value) => !!value || 'This field is required.'
      },
      itemToEditIndex: -1,
      itemToEdit: {},
      itemToDeleteIndex: -1,
      itemToDelete: null,
      itemToView: null,
      currentFilter: null,
      search: null
    }),
    computed: {
      formTitle () {
        return this.itemToEditIndex === -1 ? 'New Item' : 'Edit Item'
      }
    },
    watch: {
      editDialog (val) {
        val || this.close()
      },
      itemToView (val) {
        this.viewDialog = !!val
      },
      itemToDelete (val) {
        this.deleteDialog = !!val
      },
      currentFilter (val) {
        if (val) {
          this.initialize()
        }
      }
    },
    methods: {
      isRequired (header) {
        if (this.itemToEditIndex > -1) {
          return header.editRequired
        } else {
          return header.createRequired
        }
      },
      isEditable (header) {
        if (this.itemToEditIndex > -1) {
          return header.editable
        } else {
          return header.creatable
        }
      },
      clearItems () {
        this.items = []
      },
      setItems (items) {
        this.items = items
      },
      toPlaceholder (value) {
        return 'Enter ' + (value.toLowerCase())
      },
      toOptions (options) {
        return options.split(',')
      },
      initialize () {
        this.items = []
        let that = this
        this.$refs.connectionManager.get(this.resource, {
          onSuccess (response) {
            that.$utils.log(response.data)
            that.$utils.log(response.data.meta)
            that.items = []
            that.items = that.items.concat(response.data.data)
            that.headers = []
            that.headers = that.headers.concat(response.data.meta.headers)
            that.browsableHeaders = that.headers.filter((header) => {
              return header.browsable
            })
            that.viewableHeaders = that.headers.filter((header) => {
              return header.viewable
            })
            that.browsableHeaders.push({
              text: 'Actions',
              value: 'actions',
              align: 'center',
              sortable: false
            })
          }
        }, {filter: this.currentFilter ? this.currentFilter.value : ''})
      },
      viewItem (item) {
        if (!this.manager.hasCustomView(item, this.viewableHeaders)) {
          this.itemToView = item
        }
      },
      editItem (item) {
        this.itemToEditIndex = this.items.indexOf(item)
        this.itemToEdit = Object.assign({}, item)
        this.editDialog = true
      },

      deleteItem (item) {
        this.itemToDelete = item
        this.itemToDeleteIndex = this.items.indexOf(item)
        //confirm('Are you sure you want to delete this item?') && this.items.splice(deleteIndex, 1)
      },

      doDelete () {
        let that = this
        this.$refs.deleteConnectionManager.delete(this.resource + '/' + this.itemToDelete.id, {
          onSuccess (response) {
            that.items.splice(that.itemToDeleteIndex, 1)
            that.itemToDelete = null
            that.itemToDeleteIndex = -1
            that.deleting = false
            that.$refs.deleteConnectionManager.reset()
          }
        })
      },
      updateItem (updatedItem) {
        this.$utils.log('updateItem')
        let itemToUpdate = this.items.find(item => item.id === updatedItem.id)
        let indexOfItemToUpdate = this.items.indexOf(itemToUpdate)
        Object.assign(this.items[indexOfItemToUpdate], updatedItem)
      },
      removeItem (updatedItem) {
        this.$utils.log('removeItem')
        let itemToRemove = this.items.find(item => item.id === updatedItem.id)
        this.items.splice(itemToRemove, 1)
      },
      close () {
        this.editDialog = false
        setTimeout(() => {
          this.itemToEdit = Object.assign({}, {})
          this.itemToEditIndex = -1
          this.$refs.form.reset()
          this.$refs.editConnectionManager.reset()
        }, 300)
      },
      save () {
        this.$utils.log('Saving item...')
        this.$utils.log(this.itemToEdit)
        let that = this
        if (this.itemToEditIndex > -1 && this.$refs.form.validate()) {
          this.$refs.editConnectionManager.patch(this.resource + '/' + this.itemToEdit.id, {
            onSuccess (response) {
              Object.assign(that.items[that.itemToEditIndex], response.data.data)
              that.close()
            }
          }, this.itemToEdit)
        } else if (this.$refs.form.validate()) {
          this.$refs.editConnectionManager.post(this.resource, {
            onSuccess (response) {
              that.items.push(response.data.data)
              that.close()
            }
          }, this.itemToEdit)

        }
      }
    },
    mounted () {
      if (this.filters) {
        this.currentFilter = this.filters[0]
      } else {
        this.initialize()
      }
    }
  }
</script>

<style scoped>

</style>