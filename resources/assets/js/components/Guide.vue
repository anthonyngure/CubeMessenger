<template >
  <v-chip class="mt-3 caption"
          label
          outline
          color="info"
          small >
    <v-icon left >info</v-icon >
    {{text}}
  </v-chip >
</template >

<script >
export default {
  name: 'Guide',
  props: {
    text: {
      type: String,
      required: true
    }
  }
}
</script >

<style scoped >

</style >