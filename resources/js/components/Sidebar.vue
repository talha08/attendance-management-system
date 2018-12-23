<template>
  <el-row class="tac">
    <el-col>
      <el-menu
        :router="true"
        default-active="/dashboard"
        class="el-menu-vertical-demo"
      >
        <el-menu-item index="/dashboard">
          <i class="el-icon-menu" />
          <span>Dashboard</span>
        </el-menu-item>

        <el-menu-item index="/dashboard/users">
          <i class="el-icon-menu" />
          <span>Employees</span>
        </el-menu-item>

        <el-menu-item index="/dashboard/salary">
          <i class="el-icon-menu" />
          <span>Salary</span>
        </el-menu-item>

        <el-menu-item index="/dashboard/positions">
          <i class="el-icon-menu" />
          <span>Positions</span>
        </el-menu-item>

        <el-menu-item index="/dashboard/holidays">
          <i class="el-icon-menu" />
          <span>Holidays</span>
        </el-menu-item>

        <el-submenu index="1">
          <template slot="title">
            <i class="el-icon-location" />
            <span>Attendances</span>
          </template>
          <el-menu-item index="/dashboard/attendance">Attendance</el-menu-item>
          <el-menu-item index="/dashboard/attendance/calendar">Attendance Calendar</el-menu-item>
        </el-submenu>

        <el-menu-item index="/dashboard/reports">
          <i class="el-icon-document" />
          <span>Report</span>
        </el-menu-item>

        <el-menu-item index="5">
          <i class="el-icon-setting" />
          <span>Statistics</span>
        </el-menu-item>
      </el-menu>
    </el-col>
  </el-row>
</template>
<script>
export default {
  name: 'Sidebar'
}
</script>

<style scoped>
</style>
