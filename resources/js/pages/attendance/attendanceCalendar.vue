<template>
  <div>
    <card title="Attendance">
      <full-calendar
        ref="calendar"
        :config="config"
        :events="events"
        @view-render="viewRender"
        @day-click="dayClick"
        @event-selected="eventSelected"
      />
    </card>

    <el-dialog :title="`${clickDate} || Attendances`" :visible.sync="dayDialogVisible">
      <div v-if="dayEvents">
        <el-card v-for="(dayEvent,index) in dayEvents" :key="index" shadow="always">
          <el-row type="flex" class="row-bg" justify="space-around">
            <el-col :span="6">
              <img
                :src="dayEvent.user.userInfo.photo ? dayEvent.user.userInfo.photo : '../../assets/user.png'"
                height="30px"
                class="border"
              >
              {{ dayEvent.user.name }}
            </el-col>
            <el-col :span="6">
              <b>{{ dayEvent.total_worked_time }} Hours</b>
            </el-col>
          </el-row>
        </el-card>
      </div>
      <div v-if="!dayEvents">No Attendance Found in this Date!!</div>
    </el-dialog>

    <el-dialog title="Attendance Details" :visible.sync="eventDialogVisible">
      <el-card v-if="eventDetails" shadow="always">
        <el-row type="flex" class="row-bg" justify="space-around">
          <el-col :span="6">
            <img
              :src="eventDetails.user.userInfo.photo ? eventDetails.user.userInfo.photo : '../../assets/user.png'"
              height="100px"
              class="border"
            >
          </el-col>
          <el-col :span="6">
            Name: {{ eventDetails.user.name }}
            <br>
            Email: {{ eventDetails.user.email }}
            Position: {{ eventDetails.user.userInfo.position.position }}
            <br>
            Phone: {{ eventDetails.user.userInfo.phone }}
            <br>
          </el-col>
          <el-col :span="6">Date:
            <br>
            {{ eventDetails.work_date }}
            <br>Woking Time:
            <br>
            <b>{{ eventDetails.total_worked_time }} Hours</b>
          </el-col>
        </el-row>
      </el-card>
    </el-dialog>
  </div>
</template>

<script>
import moment from 'moment'
import FullCalendar from '../../components/Fullcalendar'
import { GET } from '../../plugins/axios'
import { CALENDAR_ATTENDANCE_BY_MONTH, CALENDAR_ATTENDANCE_BY_DATE } from '../../const/api'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Attendance' }
  },
  components: {
    FullCalendar
  },
  data () {
    return {
      dayDialogVisible: false,
      eventDialogVisible: false,
      clickDate: '',
      curentDate: moment().format('YYYY-MM-DD'),
      // calendar
      events: [],
      dayEvents: [],
      eventDetails: null,
      config: {
        weekends: true,
        defaultView: 'month',
        weekNumbers: true,
        navLinks: true,
        editable: true,
        eventLimit: true,
        header: {
          left: 'prevYear,prev,next,nextYear today',
          center: 'title',
          right: 'month,basicWeek,listMonth'
        }
      }
    }
  },
  // created () {
  //   this.bootstrapping()
  // },
  methods: {
    async bootstrapping () {
      await this.getAllAttendancesByMonth()
    },
    async getAllAttendancesByMonth () {
      const { data } = await GET(CALENDAR_ATTENDANCE_BY_MONTH, { date: this.curentDate })
      this.events = data
    },

    async dayClick (date, jsEvent, view) {
      this.dayDialogVisible = true
      this.clickDate = moment(date.format()).format('dddd, MMMM Do YYYY') // for title show
      const { data } = await GET(CALENDAR_ATTENDANCE_BY_DATE, { date: date.format() })
      this.dayEvents = data
    },
    async eventSelected (event, jsEvent, view) {
      this.eventDialogVisible = true
      const { data } = await GET(`/api/attendance/${event.attendance_id}/calendar?include=user`)
      this.eventDetails = data
    },
    // work as created cycle
    viewRender (view, element) {
      var b = this.$refs.calendar.fireMethod('getDate')
      this.curentDate = b.format('YYYY-MM-DD')
      console.log(b.format('YYYY-MM-DD'))
      this.getAllAttendancesByMonth()
    }
  }
}
</script>
