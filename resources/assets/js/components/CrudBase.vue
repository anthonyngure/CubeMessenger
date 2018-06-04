<script>
  import Base from './Base.vue'

  export default {
    name: 'CrudBase',
    extends: Base,
    data () {
      return {
        headers: [],
        manager: {},
        defaultValue: '_____',
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
        extraTopActions: [
          {name: 'Test Action'}
        ]
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
          hasCustomView (item, viewableHeaders, viewItemHeaders) {
            return false
          },
          toValue: (header, item) => {
            return item[header.value] ? item[header.value] : that.defaultValue
          },
          nameOnDelete (item) {
            return item.name
          },
          onTopAction(action, items, filter){
          },
          showTopAction(action, items, filter){
            return true;
          }

        }
      }
    }
  }
</script>

<style scoped>

</style>