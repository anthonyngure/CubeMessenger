<template >
  <v-layout row
            wrap >
    <v-flex xs12 >
      <v-card >
        <v-card-media :src="$utils.imageUrl($auth.user().client.logo)"
                      height="250px" >
        </v-card-media >
        <v-card-text >
          <v-layout row
                    wrap >
            <v-flex xs2 >
              <v-avatar size="128px"
                        class="ma-3" >
                <img :src="$utils.imageUrl($auth.user().avatar)" />
              </v-avatar >
            </v-flex >
            <v-flex xs4
                    class="align-center mt-4"
                    justify-center >
              <h3 class="headline"
                  style="text-transform: uppercase" >
                {{$auth.user().name}}
                <small >{{$auth.user().role.name}}</small >
              </h3 >
              <h3 class="title" >{{$auth.user().department.name}}</h3 >
              <h3 class="subheading" >{{$auth.user().email}}</h3 >
              <v-btn small
                     block
                     color="success" >Change Password
              </v-btn >
            </v-flex >
            <!--<v-flex style="align-self: center">
                <v-avatar size="128px" id="avatar" class="mx-auto">
                    <img :src="$utils.imageUrl($auth.user().avatar)"/>
                </v-avatar>
            </v-flex>-->
          </v-layout >
        </v-card-text >
      </v-card >
    </v-flex >
  </v-layout >
</template >

<script >
export default {
  name: 'Settings'
}
</script >

<style scoped >
  
  #avatar {
    margin-top: -20px;
  }
</style >