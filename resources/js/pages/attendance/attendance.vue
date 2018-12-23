<template>
  <el-row :gutter="20">
    <el-col :span="18">
      <el-card shadow="always">
        <div slot="header" class="clearfix">
          <span>Today Attendances</span>
        </div>
        <attednace-process />
      </el-card>
    </el-col>
    <el-col :span="6">
      <widget />
    </el-col>
  </el-row>
</template>

<script>
import widget from './widget'
import attednaceProcess from './attednaceProcess'

export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Attendance' }
  },
  components: {
    widget,
    attednaceProcess
  }

}
</script>
