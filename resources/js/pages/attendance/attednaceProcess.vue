<template>
  <div v-if="users">
    <el-card v-for="(user,index) in users" :key="index" shadow="always">
      <el-row>
        <el-col :span="6">
          <div>
            <img
              :src="user.photo ? user.photo : '../../assets/user.png'"
              class="img-responsive"
              alt="Photo"
              height="40"
            >
            {{ user.name }}
          </div>
        </el-col>

        <el-col :span="4">
          <div>
            <i :style="statusColor(user.status)" :class="statusIcon(user.status)" />
            {{ statusName(user.status) }}
          </div>
        </el-col>

        <el-col :span="8">
          <div>
            <el-progress
              :text-inside="true"
              :stroke-width="18"
              :percentage="hourMinuteToSecondConvert(user.total_worked_time).percentage"
              :color="hourMinuteToSecondConvert(user.total_worked_time).color"
            />
          </div>
        </el-col>

        <el-col :span="6">
          <div class="text-right">
            <i class="el-icon-time" />
            {{ user.total_worked_time }} H:m
          </div>
        </el-col>
      </el-row>
    </el-card>
    <!-- Pagination -->
    <br>
    <div v-if="users && paginate && paginate.total >= paginate.per_page" class="block pagination">
      <el-pagination
        :current-page.sync="paginate.current_page"
        :total="paginate.total"
        :page-count="paginate.total_pages"
        :page-size="paginate.per_page"
        background
        layout="total, prev, pager, next, jumper"
        @current-change="handleCurrentChange"
      />
    </div>
    <!--End of Pagination -->
  </div>
</template>

<script>
import { USER_ATTENDANCE_STATISTICS_TODAY_PERCENTAGE } from '../../const/api'
import { GET } from '../../plugins/axios'
export default {
  data () {
    return {
      users: [],
      paginate: {}
    }
  },
  computed: {
    userGetters () {
      return this.$store.getters.user.userInfo.position.work_hour_per_day
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    async bootstrapping () {
      await this.getUserStatisticsForToday(1)
    },
    async getUserStatisticsForToday (page) {
      const { data } = await GET(`${USER_ATTENDANCE_STATISTICS_TODAY_PERCENTAGE}?page=${page}`)
      // eslint-disable-next-line no-undef
      this.users = _.sortBy(data.data, 'total_worked_time').reverse()
      this.paginate = data.meta.pagination
    },
    async handleCurrentChange (val) {
      await this.getUserStatisticsForToday(val)
    },
    statusIcon (status) {
      if (status === 'start') return 'el-icon-loading'
      else if (status === 'pause') return 'el-icon-warning'
      else if (status === 'finish') return 'el-icon-success'
      else return 'el-icon-error'
    },
    statusColor (status) {
      if (status === 'start') return 'color:#186A3B'
      else if (status === 'pause') return 'color:#DC7633'
      else if (status === 'finish') return 'color:#081F4B'
      else return 'color:#CD6155'
    },
    statusName (status) {
      if (status === 'start') return 'Active'
      else if (status === 'pause') return 'Pause'
      else if (status === 'finish') return 'Finished'
      else return 'Inactive'
    },
    hourMinuteToSecondConvert (time) {
      let splitTime = time.split(':') // splits the colon
      let WorkingSeconds = (+splitTime[0]) * 60 * 60 + (+splitTime[1]) * 60 // H:m to s
      let destinationTime = this.userGetters * 60 * 60 // hour to second
      let percentage = (WorkingSeconds / destinationTime) * 100
      let color
      if (percentage) {
        if (percentage < 10) { color = '#CD6155' } else if (percentage > 10) { color = '#F1948A' } else if (percentage > 25) { color = '#1F618D' } else if (percentage > 50) { color = '#3498DB' } else if (percentage > 70) { color = '#1ABC9C' } else if (percentage > 95) { color = '#1D8348' } else { color = '#1D8348' }
      }
      return {
        'percentage': Math.round(percentage),
        'color': color
      }
    }
  }
}
</script>

<style scoped>

</style>
