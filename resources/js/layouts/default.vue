<template>
  <el-container>
    <el-header>
      <navbar />
    </el-header>
    <el-container>
      <el-aside width="200px">
        <sidebar />
      </el-aside>
      <el-container>
        <el-main>
          <router-view />
        </el-main>
      </el-container>
    </el-container>
  </el-container>
</template>

<script>
import Navbar from '~/components/Navbar'
import Sidebar from '~/components/Sidebar'
export default {
  name: 'MainLayout',
  components: {
    Navbar,
    Sidebar
  }
}
</script>
<style>
  header.el-header {
    padding-left: 0px;
    padding-right: 0px;
  }
  body > .el-container {
    margin-bottom: 40px;
  }

  .el-container:nth-child(5) .el-aside,
  .el-container:nth-child(6) .el-aside {
    line-height: 260px;
  }

  .el-container:nth-child(7) .el-aside {
    line-height: 320px;
  }
</style>
