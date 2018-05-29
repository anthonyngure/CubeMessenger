<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <v-toolbar color="primary"
                 extended ></v-toolbar >
      <v-layout row
                wrap >
        <v-flex xs12
                sm8
                offset-sm2 >
          <v-card style="margin-top: -64px" >
            <v-toolbar color="white" >
              <v-icon >group</v-icon >
              <v-toolbar-title >Users</v-toolbar-title >
            </v-toolbar >
            <connection-manager ref="connectionManager" ></connection-manager >
            <v-list three-line >
              <template v-for="(user, index) in users" >
                <v-list-tile :key="user.id" >
                  <v-list-tile-avatar >
                    <img :src="$utils.imageUrl(user.avatar)" >
                  </v-list-tile-avatar >
                  <v-list-tile-content >
                    <v-list-tile-title v-html="user.role.name" ></v-list-tile-title >
                    <v-list-tile-sub-title v-html="user.name" ></v-list-tile-sub-title >
                    <v-list-tile-sub-title v-html="user.email" ></v-list-tile-sub-title >
                  </v-list-tile-content >
                  <v-list-tile-action >
                    <v-btn icon
                           class="mx-0"
                           v-if="user.id !== $auth.user().id"
                           @click="editItem(user)" >
                      <v-icon color="success" >edit</v-icon >
                    </v-btn >
                    <v-btn icon
                           class="mx-0"
                           v-if="user.id !== $auth.user().id"
                           @click="deleteItem(user)" >
                      <v-icon color="red" >delete</v-icon >
                    </v-btn >
                  </v-list-tile-action >
                </v-list-tile >
                <v-divider v-if="index !== (users.length - 1)"
                           inset
                           :key="user.email+'_'+user.phone" >
                </v-divider >
              </template >
            </v-list >
          
          </v-card >
        </v-flex >
      </v-layout >
    </v-flex >
    
    <v-fab-transition >
      <v-btn class="ma-5"
             color="accent"
             fab
             dark
             fixed
             bottom
             @click.native="editDialog = true"
             right >
        <v-icon >add</v-icon >
      </v-btn >
    </v-fab-transition >
    
    
    <v-dialog v-model="editDialog"
              lazy
              max-width="600px"
              persistent >
      <v-card >
        <v-toolbar dark
                   card
                   color="primary" >
          <v-icon >person</v-icon >
          <v-toolbar-title >Add User</v-toolbar-title >
        </v-toolbar >
        
        <connection-manager ref="editConnectionManager"
                            v-model="editingUser" >
        </connection-manager >
        
        <v-card-text >
          <v-form ref="form"
                  v-model="formValid"
                  lazy-validation >
            <v-text-field
              placeholder="Full name"
              label="Enter full name"
              required
              type="text"
              :rules="[rules.required]"
              :disabled="editingUser"
              v-model="userToEdit['name']" >
            </v-text-field >
            <v-text-field label="Enter phone number"
                          placeholder="Phone number"
                          v-model="userToEdit['phone']"
                          required
                          :rules="[rules.required, rules.phone]"
                          type="phone"
                          :disabled="editingUser"
                          class="mb-2"
                          mask="##########"
                          :counter="10"
                          hint="A password will be sent to this phone number"
                          persistent-hint >
            </v-text-field >
            <v-text-field
              placeholder="Password"
              label="Enter a password"
              required
              type="password"
              :rules="userToEditIndex > -1 ? [] : [rules.required]"
              :hint="userToEditIndex > -1 ? 'Leave empty to keep the same password' :
              'Password will be sent to the user phone number'"
              :disabled="editingUser"
              persistent-hint
              v-model="userToEdit['password']" >
            </v-text-field >
            <v-text-field
              placeholder="Email address"
              label="Enter email address"
              required
              type="email"
              :rules="[rules.required, rules.email]"
              :disabled="editingUser"
              v-model="userToEdit['email']" >
            </v-text-field >
            <v-select
              :items="roles"
              v-model="roleName"
              required
              label="Select user role"
              :disabled="editingUser"
              clearable >
            </v-select >
            <v-select
              :items="$auth.user().client.departments"
              v-model="userToEdit['departmentId']"
              v-if="roleName !== 'ADMIN' && roleName !==   'PURCHASING_HEAD'"
              item-text="name"
              item-value="id"
              required
              label="Select department"
              :disabled="editingUser"
              clearable >
            </v-select >
          </v-form >
        </v-card-text >
        
        <v-card-actions >
          <v-spacer ></v-spacer >
          <v-btn color="red"
                 flat
                 :disabled="editingUser"
                 @click="close" >Cancel
          </v-btn >
          <v-btn color="primary"
                 :disabled="editingUser || !formValid || !roleName"
                 @click="save" >Add User
          </v-btn >
        </v-card-actions >
      </v-card >
    </v-dialog >
    
    <v-dialog v-model="deleteDialog"
              max-width="500px"
              persistent >
      <v-card v-if="userToDelete" >
        <v-card-text >
          <connection-manager ref="deleteConnectionManager"
                              v-model="deletingUser" >
          </connection-manager >
          
          <p >Confirm you want to delete </p > <b >{{userToDelete.name}}</b >
        
        </v-card-text >
        
        <v-card-actions >
          <v-spacer ></v-spacer >
          <v-btn color="red"
                 flat
                 :disabled="deletingUser"
                 @click.native="doDelete" >Delete
          </v-btn >
          <v-btn color="primary"
                 flat
                 :disabled="deletingUser"
                 @click.native="userToDelete = null" >Cancel
          </v-btn >
        </v-card-actions >
      </v-card >
    </v-dialog >
  
  </v-layout >
</template >

<script >
import ConnectionManager from './ConnectionManager'
import Base from './Base'
import AddUserDialog from './AddUserDialog'

export default {
  extends: Base,
  components: {AddUserDialog, ConnectionManager, Base},
  name: 'ClientUsers',
  data () {
    return {
      editingUser: false,
      deletingUser: false,
      deleteDialog: false,
      editDialog: false,
      formValid: false,
      users: [],
      userToEditIndex: -1,
      userToEdit: {},
      userToDeleteIndex: -1,
      userToDelete: null,
      roleName: null,
      roles: [
        'ADMIN',
        'PURCHASING_HEAD',
        'DEPARTMENT_HEAD',
        'DEPARTMENT_USER'
      ]
    }
  },
  watch: {
    userToDelete (val) {
      this.deleteDialog = !!val
    }
  },
  methods: {
    editItem (item) {
      this.userToEditIndex = this.users.indexOf(item)
      this.userToEdit = Object.assign({}, item)
      this.roleName = this.userToEdit.role.name
      this.editDialog = true
    },
    
    deleteItem (item) {
      this.$utils.log(item)
      this.userToDelete = item
      this.userToDeleteIndex = this.users.indexOf(item)
      //confirm('Are you sure you want to delete this item?') && this.users.splice(this.userToDeleteIndex, 1)
    },
    doDelete () {
      let that = this
      this.$refs.deleteConnectionManager.delete('/users/' + that.userToDelete.id, {
        onSuccess (response) {
          that.users.splice(that.userToDeleteIndex, 1)
          that.userToDelete = null
          that.userToDeleteIndex = -1
          that.deletingUser = false
          that.$refs.deleteConnectionManager.reset()
        }
      })
    },
    close () {
      this.editDialog = false
      setTimeout(() => {
        this.userToEdit = Object.assign({}, {})
        this.userToEditIndex = -1
        this.$refs.form.reset()
        this.$refs.editConnectionManager.reset()
      }, 300)
    },
    
    save () {
      this.$utils.log('Saving item...')
      this.$utils.log(this.userToEdit)
      this.userToEdit['role'] = this.roleName
      let that = this
      if (this.userToEditIndex > -1 && this.$refs.form.validate()) {
        this.$refs.editConnectionManager.patch('/users/' + this.userToEdit.id, {
          onSuccess (response) {
            Object.assign(that.users[that.userToEditIndex], response.data.data)
            that.close()
          }
        }, this.userToEdit)
      } else if (this.$refs.form.validate()) {
        this.$refs.editConnectionManager.post('users', {
          onSuccess (response) {
            that.users.push(response.data.data)
            that.close()
          }
        }, this.userToEdit)
        
      }
    }
  },
  mounted () {
    //this.loadUsers()
    this.users = this.$auth.user().client.users
  }
}
</script >

<style scoped >

</style >