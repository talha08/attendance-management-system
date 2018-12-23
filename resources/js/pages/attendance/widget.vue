<template>
  <div>
    <!-- Widget start -->
    <el-row class="text-center">
      <el-col>
        <el-card shadow="always">
          <fa icon="user" size="3x" color="#5D6D7E" fixed-width />
          <p class="counterValue">{{ totalUser }}</p>
          Total Employee
        </el-card>
      </el-col>
      <el-col>
        <el-card shadow="always">
          <fa icon="user" size="3x" color="#76D7C4" fixed-width />
          <p class="counterValue">{{ activeUser }}</p>
          Active Employee
        </el-card>
      </el-col>
      <el-col>
        <el-card shadow="always">
          <fa icon="user" size="3x" color="#F08080" fixed-width />
          <p class="counterValue">{{ inactiveUser }}</p>
          Inactive Employee
        </el-card>
      </el-col>

    </el-row>
    <!-- Widget End -->
  </div>
</template>

<script>
import { USER_ATTENDANCE_STATISTICS_TODAY } from '../../const/api'
import { GET } from '../../plugins/axios'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Attendence-Widget' }
  },
  data () {
    return {
      totalUser: 0,
      activeUser: 0,
      inactiveUser: 0
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    async bootstrapping () {
      await this.getUserStatisticsForToday()
    },
    async getUserStatisticsForToday () {
      const { data } = await GET(USER_ATTENDANCE_STATISTICS_TODAY)
      this.totalUser = data.total
      this.activeUser = data.active
      this.inactiveUser = data.inactive
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
