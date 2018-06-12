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
        extraInlineActions: [
          /*
          Actions should be name,color objects e.g
          {
            name: 'Approve',
            color: 'accent'
          }, {
            name: 'Reject',
            color: 'primary'
          }*/
        ],
        extraOverflowActions: [
          /*
          Actions should be name,color objects e.g
          {
            name: 'Approve',
            color: 'accent'
          }, {
            name: 'Reject',
            color: 'primary'
          }*/

        ],
        extraTopActions: [
          /*
          Actions should be name,color, key objects e.g
          {
            name: 'Approve',
            color: 'accent',
            key: 'ddd'
          }, {
            name: 'Reject',
            color: 'primary'
          }*/
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