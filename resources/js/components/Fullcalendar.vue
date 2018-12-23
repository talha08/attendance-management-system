<template>
  <div id="calendar" ref="calendar" />
</template>

<script>
import defaultsDeep from 'lodash.defaultsdeep'
import 'fullcalendar'
import $ from 'jquery'

export default {
  props: {
    events: {
      type: Array,
      default: function () {
        return []
      }
    },

    eventSources: {
      type: Array,
      default: function () {
        return []
      }
    },

    editable: {
      type: Array,
      default: function () {
        return []
      }
    },

    selectable: {
      type: Array,
      default: function () {
        return []
      }
    },

    selectHelper: {
      type: Array,
      default: function () {
        return []
      }
    },

    // eslint-disable-next-line vue/require-prop-types
    header: {
      default: function () {
        return {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        }
      }
    },

    defaultView: {
      type: String,
      default: 'agendaWeek'
    },

    sync: {
      type: Boolean,
      default: false
    },

    config: {
      type: Object,
      default () {
        return {}
      }
    }
  },

  computed: {
    defaultConfig () {
      const self = this
      return {
        header: this.header,
        defaultView: this.defaultView,
        editable: this.editable,
        selectable: this.selectable,
        selectHelper: this.selectHelper,
        aspectRatio: 2,
        timeFormat: 'HH:mm',
        events: this.events,
        eventSources: this.eventSources,

        eventRender (...args) {
          if (this.sync) {
            // eslint-disable-next-line no-undef
            self.events = cal.fullCalendar('clientEvents')
          }
          self.$emit('event-render', ...args)
        },

        viewRender (...args) {
          if (this.sync) {
            // eslint-disable-next-line no-undef
            self.events = cal.fullCalendar('clientEvents')
          }
          self.$emit('view-render', ...args)
        },

        eventDestroy (event) {
          if (this.sync) {
            // eslint-disable-next-line no-undef
            self.events = cal.fullCalendar('clientEvents')
          }
        },

        eventClick (...args) {
          self.$emit('event-selected', ...args)
        },

        eventDrop (...args) {
          self.$emit('event-drop', ...args)
        },

        eventReceive (...args) {
          self.$emit('event-receive', ...args)
        },

        eventResize (...args) {
          self.$emit('event-resize', ...args)
        },

        dayClick (...args) {
          self.$emit('day-click', ...args)
        },
        select (start, end, jsEvent, view, resource) {
          self.$emit('event-created', {
            start,
            end,
            allDay: !start.hasTime() && !end.hasTime(),
            view,
            resource
          })
        }
      }
    }
  },

  watch: {
    events: {
      deep: true,
      handler (val) {
        $(this.$el).fullCalendar('removeEvents')
        $(this.$el).fullCalendar('addEventSource', this.events)
      }
    },
    eventSources: {
      deep: true,
      handler (val) {
        this.$emit('rebuild-sources')
      }
    }
  },

  mounted () {
    const cal = $(this.$el)

    // eslint-disable-next-line no-unused-vars
    const self = this

    this.$on('remove-event', (event) => {
      if (event && event.hasOwnProperty('id')) {
        $(this.$el).fullCalendar('removeEvents', event.id)
      } else {
        $(this.$el).fullCalendar('removeEvents', event)
      }
    })

    this.$on('rerender-events', () => {
      $(this.$el).fullCalendar('rerenderEvents')
    })

    this.$on('refetch-events', () => {
      $(this.$el).fullCalendar('refetchEvents')
    })

    this.$on('render-event', (event) => {
      $(this.$el).fullCalendar('renderEvent', event)
    })

    this.$on('reload-events', () => {
      $(this.$el).fullCalendar('removeEvents')
      $(this.$el).fullCalendar('addEventSource', this.events)
    })

    this.$on('rebuild-sources', () => {
      $(this.$el).fullCalendar('removeEventSources')
      this.eventSources.map(event => {
        $(this.$el).fullCalendar('addEventSource', event)
      })
    })

    cal.fullCalendar(defaultsDeep(this.config, this.defaultConfig))
  },

  beforeDestroy () {
    this.$off('remove-event')
    this.$off('rerender-events')
    this.$off('refetch-events')
    this.$off('render-event')
    this.$off('reload-events')
    this.$off('rebuild-sources')
  },

  methods: {
    fireMethod (...options) {
      return $(this.$el).fullCalendar(...options)
    }
  }
}
</script>
