<template>
  <card title="Your Dashboard">
    <!-- Your Attendance Start -->
    <el-row>
      <el-col>
        <el-card shadow="always">
          <el-row :gutter="20">
            <el-col :span="8">
              <img :src="userGetters.userInfo.photo" class="attendance-user border border-success">
              <b>{{ userGetters.name }}</b>
            </el-col>
            <el-col :span="8" class="text-center">
              <el-button type="warning" plain round disabled>
                <i class="el-icon-time" />
                <b>{{ hours }}:{{ minutes }}:{{ seconds }}</b>
              </el-button>
            </el-col>
            <el-col v-if="currentStatus != 'finish'" :span="8" class="text-right">
              <el-button
                v-if="currentStatus == 'pause' || currentStatus == 'idle'"
                type="primary"
                plain
                round
                @click="startTimer"
              >
                <fa icon="pause" />Start
              </el-button>

              <el-button
                v-if="currentStatus == 'start'"
                type="warning"
                icon="el-icon-caret-right"
                plain
                round
                @click="pauseTimer"
              >Pause</el-button>

              <el-button
                v-if="currentStatus == 'pause'"
                type="danger"
                icon="el-icon-caret-right"
                plain
                round
                @click="stopTimer"
              >Stop</el-button>

              <!-- <el-button v-if="resetButton" type="primary" icon="el-icon-refresh" plain round @click="resetTimer">
                Reset
              </el-button>-->
            </el-col>
          </el-row>
        </el-card>
      </el-col>
    </el-row>
    <!-- Your Attendance End -->
    <br>
    <ststistics />
  </card>
</template>

<script>
import {
  ATTENDANCE_CREATE,
  TODAY_ATTENDANCE_FOR_SPECIFIC_USER
} from '../../const/api.js'
import moment from 'moment'
import ststistics from './ststistics'
import { PATCH, POST, GET } from '../../plugins/axios.js'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'HOME' }
  },
  components: {
    ststistics
  },
  data () {
    return {
      timer: null,
      totalTime: 1,
      resetButton: false,
      startTime: null,
      currentSavedTime: 0,
      previousTotalWorkTime: 0,
      currentStatus: 'idle',
      currentAttendanceId: null,
      isCounterAlredayStarted: false // for first time hit start
    }
  },
  computed: {
    userGetters () {
      return this.$store.getters.user
    },
    hours () {
      const hours = Math.floor(this.totalTime / 60 / 60)
      return this.padTime(hours)
    },
    minutes () {
      const minutes = Math.floor(this.totalTime / 60)
      return this.padTime(minutes)
    },
    seconds () {
      const seconds = this.totalTime - this.minutes * 60
      return this.padTime(seconds)
    }
  },

  beforeDestroy () {
    clearInterval(this.timer)
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    bootstrapping () {
      this.getTodayAttendanceForSpecificUser()
    },

    async getTodayAttendanceForSpecificUser () {
      let { data } = await GET(TODAY_ATTENDANCE_FOR_SPECIFIC_USER)
      if (data.counter_status) {
        this.currentStatus = data.status
        this.currentAttendanceId = data.attendance_id
        this.previousTotalWorkTime = data.total_worked_time
        let momentTime = moment().valueOf()
        if (data.total_worked_time) {
          if (data.status === 'start') {
            this.totalTime =
              Math.floor(this.previousTotalWorkTime) +
              Math.floor((momentTime - parseInt(data.break_entry_time)) / 1000)
          } else {
            this.totalTime = Math.floor(this.previousTotalWorkTime)
          }
        } else {
          this.totalTime = Math.floor(
            (momentTime - parseInt(data.entry_time)) / 1000
          )
        }
        this.isCounterAlredayStarted = true
        this.currentSavedTime = parseInt(data.break_entry_time)
        if (data.status === 'start') {
          this.timer = setInterval(() => this.countdown(), 1000)
        }
      } else {
        this.totalTime = 1
      }
    },

    async startTimer () {
      this.timer = setInterval(() => this.countdown(), 1000)
      let momentTime = moment().valueOf()
      if (this.isCounterAlredayStarted === false) {
        this.isCounterAlredayStarted = true
        this.currentSavedTime = momentTime
        let formData = {
          entry_time: momentTime,
          break_entry_time: momentTime,
          status: 'start'
        }
        const { data } = await POST(ATTENDANCE_CREATE, formData)
        this.currentAttendanceId = data.id
      } else {
        let formData = {
          status: 'start',
          break_entry_time: momentTime
        }
        this.currentSavedTime = formData.break_entry_time
        await PATCH(
          `/api/attendance/${this.currentAttendanceId}/update`,
          formData
        )
      }
      this.currentStatus = 'start'
    },

    async pauseTimer () {
      this.resetButton = true
      let momentTime = moment().valueOf()
      let formData = {
        total_worked_time: Math.floor(
          (momentTime - this.currentSavedTime) / 1000 +
            this.previousTotalWorkTime
        ),
        status: 'pause'
      }
      this.previousTotalWorkTime = formData.total_worked_time
      this.currentStatus = 'pause'
      await PATCH(
        `/api/attendance/${this.currentAttendanceId}/update`,
        formData
      )
      clearInterval(this.timer)
      this.timer = null
    },

    stopTimer () {
      this.$confirm(
        "This will stopped the counter for today, and you'll not be able to restart it. Are you agree with this?",
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
          center: true
        }
      )
        .then(async () => {
          let momentTime = moment().valueOf()
          let formData = {
            finish_time: momentTime,
            total_worked_time: this.previousTotalWorkTime,
            status: 'finish'
          }
          this.currentStatus = 'finish'
          await PATCH(
            `/api/attendance/${this.currentAttendanceId}/update`,
            formData
          )
          clearInterval(this.timer)
          this.timer = null
          this.$message({
            type: 'success',
            message: 'Your Attendance Counter for Today has been stopped'
          })
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Canceled the Event'
          })
        })
    },

    resetTimer () {
      this.totalTime = 1
      clearInterval(this.timer)
      this.timer = null
      this.resetButton = false
    },

    padTime: function (time) {
      return (time < 10 ? '0' : '') + time
    },
    countdown: function () {
      if (this.totalTime >= 1) {
        this.totalTime++
      } else {
        this.totalTime = 0
        this.resetTimer()
      }
    }
  }
}
</script>
<style scoped>
.attendance-user {
  height: 40px;
  border-radius: 30px/10px;
}
</style>
