<script >
import Base from './Base.vue'

export default {
  name: 'CrudBase',
  extends: Base,
  data () {
    return {
      headers: [],
      manager: {},
      defaultValue: '_____'
    }
  },
  created () {
    this.setDefaultManager()
    this.initialize()
  },
  methods: {
    initialize () {
    },
    setDefaultManager () {
      let that = this
      this.manager = {
        deletable: (item) => {
          return true
        },
        editable: (item) => {
          return true
        },
        creatable: () => {
          return true
        },
        hasCustomView (item, viewableHeaders, viewItemHeaders) {
          return false
        },
        extraInlineActions: [],
        extraOverflowActions: [
          /*{
            name: 'Approve',
            color: 'accent'
          }, {
            name: 'Reject',
            color: 'primary'
          }*/
        
        ],
        toValue: (header, item) => {
          return item[header.value] ? item[header.value] : that.defaultValue
        },
        nameOnDelete (item) {
          return item.name
        }
        
      }
    }
  }
}
</script >

<style scoped >

</style >