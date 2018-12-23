<template>
  <el-card class="box-card">
    <div slot="header" class="clearfix">
      <span>{{ currentDate }}</span>
      <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button>
    </div>
    <div class="text item">
      <!-- Widget start -->
      <el-row :gutter="20" class="text-center">
        <el-col :span="6">
          <el-card shadow="always">
            <fa icon="clock" size="5x" color="#5D6D7E" fixed-width />
            <p class="counterValue">{{ officeDay ? officeDay*8 : 0 }}</p>Total Office Hours
          </el-card>
        </el-col>
        <el-col :span="6">
          <el-card shadow="always">
            <fa icon="clock" size="5x" color="#F7DC6F" fixed-width />
            <p class="counterValue">{{ holiday? holiday*8 : 0 }}</p>Holiday Hours
          </el-card>
        </el-col>
        <el-col :span="6">
          <el-card shadow="always">
            <fa icon="clock" size="5x" color="#76D7C4" fixed-width />
            <p class="counterValue">{{ spentHours ? spentHours : spentHours }}</p>Worked Hours
          </el-card>
        </el-col>
        <el-col :span="6">
          <el-card shadow="always">
            <fa icon="clock" size="5x" color="#F08080" fixed-width />
            <p class="counterValue">{{ officeDay ? requiredHourCalculate : 0 }}</p>Required Hours
          </el-card>
        </el-col>
        <!-- <el-col :span="6">
        <el-card shadow="always">
          <fa icon="clock" size="5x" fixed-width />
          <p class="counterValue">23</p>
          Late Office (Day)
        </el-card>
        </el-col>-->
      </el-row>
      <!-- Widget End -->
    </div>
  </el-card>
</template>

<script>
import moment from 'moment'
import { USER_CURRENT_MONTH_ATTENDANCE_STATTISTICS } from '../../const/api.js'
import { GET } from '../../plugins/axios'
export default {
  data () {
    return {
      officeDay: 0,
      holiday: 0,
      spentHours: 0
    }
  },
  computed: {
    currentDate () {
      return moment().format('MMMM YYYY')
    },
    userWorkHourGetters () {
      return this.$store.getters.user.userInfo.position.work_hour_per_day
    },
    requiredHourCalculate () {
      return (this.officeDay * this.userWorkHourGetters) - this.spentHours
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    bootstrapping () {
      this.getUserCurrentMonthAttendanceStatistics()
    },
    async getUserCurrentMonthAttendanceStatistics () {
      const { data } = await GET(USER_CURRENT_MONTH_ATTENDANCE_STATTISTICS)
      this.officeDay = data.office_day
      this.holiday = data.holiday
      this.spentHours = data.spend_hours
    }
  }
}
</script>

<style scoped>
.counterValue{
  font-size: xx-large;
  font-family: -webkit-pictograph;
}
</style>
