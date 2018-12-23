<template>
  <card title="Base Salary">
    <!-- Start of Table -->
    <el-table
      v-if="salaryData"
      :data="salaryData.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
      style="width: 100%; margin-top: 20px"
    >
      <el-table-column type="expand">
        <template slot-scope="scope">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Slary</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr v-for="(item, index) in arrayofObjectSortByKeyDesc(scope.row.baseSalaries, 'id') " :key="index">
                <th scope="row">{{ index+1 }}</th>
                <td>{{ item.salary }}</td>
                <td>{{ item.start }}</td>
                <td>{{ item.end }}</td>
              </tr>
            </tbody>
          </table>
        </template>
      </el-table-column>
      <el-table-column label="Photo">
        <template slot-scope="scope">
          <img :src="scope.row.userInfo ? scope.row.userInfo.photo : '../../assets/user.png'" class="img-circle" alt="Photo" width="40" height="40">
        </template>
      </el-table-column>

      <el-table-column label="Name">
        <template slot-scope="scope">
          <span> {{ scope.row.name }} </span>
        </template>
      </el-table-column>

      <el-table-column
        label="Position"
      >
        <template slot-scope="scope">
          <span> {{ scope.row.userInfo.position ? scope.row.userInfo.position.position_name : '' }} </span>
        </template>
      </el-table-column>

      <el-table-column
        label="Salary(Taka)"
      >
        <template slot-scope="scope">
          <span>৳ {{ scope.row.baseSalaries[0] ? scope.row.baseSalaries[0].salary : 0 }} </span>
        </template>
      </el-table-column>

      <el-table-column
        align="right"
      >
        <template slot="header" slot-scope="scope">
          <el-input
            v-model="search"
            size="mini"
            placeholder="Type to search"
          />
        </template>
        <template slot-scope="scope">
          <el-button
            size="mini"
            type="success"
            plain
            @click="handleNewEntryForUser(scope.$index, scope.row)"
          >
            <i class="el-icon-circle-plus-outline" />
          </el-button>
        </template>
      </el-table-column>

    </el-table>
    <!-- End of Table -->

    <!-- Pagination -->
    <div
      v-if="salaryData && paginate && paginate.total >= paginate.per_page"
      class="block pagination"
    >
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

    <el-dialog
      title="New Salary"
      :visible.sync="newDialogVisible"
      width="50%"
      center
    >
      <el-form ref="userForm" :model="userForm" :rules="rules">
        <el-form-item label="Salary(TAKA)" prop="salary">
          <el-input v-model.number="userForm.salary" />
        </el-form-item>
        <el-form-item>
          <el-button @click="newDialogVisible = false">Cancel</el-button>
          <el-button type="primary" @click="submitNewEntryData('userForm')">Confirm</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>

  </card>
</template>

<script>
import moment from 'moment'
import { USER_NEW_SALARY, USER_CURRENT_SALARY } from '../../const/api'
import { GET, POST } from '../../plugins/axios.js'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Salary' }
  },
  data () {
    return {
      salaryData: [],
      search: '',
      paginate: {},
      newDialogVisible: false,
      currentUser: null,
      currentPage: 1,
      userForm: {
        salary: ''
      },
      rules: {
        name: [
          { required: true, message: 'Please input Salary First', trigger: 'blur' }
        ]
      }
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    arrayofObjectSortByKeyDesc (array, key) {
      // eslint-disable-next-line no-undef
      return _.sortBy(array, key).reverse()
    },
    bootstrapping () {
      this.getUserSalaries()
    },
    async getUserSalaries () {
      const { data } = await GET(`${USER_CURRENT_SALARY}&page=${this.currentPage}`)
      this.salaryData = data.data
      this.paginate = data.meta.pagination
    },
    async handleCurrentChange (val) {
      this.currentPage = val
      await this.getUserSalaries()
    },
    handleNewEntryForUser (index, row) {
      this.userForm.salary = ''
      this.newDialogVisible = true
      this.currentUser = row.id
    },
    submitNewEntryData (userForm) {
      this.$refs[userForm].validate(async (valid) => {
        try {
          if (valid && this.userForm.salary) {
            let inputData = {
              salary: this.userForm.salary,
              user_id: this.currentUser,
              start_date: moment().format('YYYY-MM-DD')
            }
            await POST(USER_NEW_SALARY, inputData)
            await this.getUserSalaries()
            this.newDialogVisible = false
            return true
          } else {
            return false
          }
        } catch (ex) {
          this.newDialogVisible = false
        }
      })
    }
  }
}
</script>

<style>
   .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
  }
  .pagination{
    padding-top: 30px;
    padding-bottom: 30px
  }
</style>
