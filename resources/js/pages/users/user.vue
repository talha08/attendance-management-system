<template>
  <div>
    <!-- New user create -->
    <el-button @click="handleCreate()">
      <i class="el-icon-plus" />
      New Employee
    </el-button>
    <!-- End of new user create -->
    <!-- Start of Table -->
    <el-table v-if="usersData" :data="usersData" style="width: 100%; margin-top: 20px">
      <el-table-column type="expand" prop="id">
        <template slot-scope="props">
          <el-row type="flex" class="row-bg" justify="space-around">
            <el-col :span="2">
              <div class="grid-content bg-purple">
                <img
                  :src="props.row.userInfo ? props.row.userInfo.photo : '../../assets/user.png'"
                  class="img-responsive"
                  alt="Photo"
                  width="250"
                  height="250"
                >
              </div>
            </el-col>
            <el-col :span="8">
              <div class="grid-content bg-purple">
                <el-card>
                  <p style="text-transform:capitalize;">Name: {{ props.row.name }}</p>
                  <p>Email: {{ props.row.email }}</p>
                  <p style="text-transform:capitalize;">Role: {{ props.row.role }}</p>
                  <p
                    style="text-transform:capitalize;"
                  >Position: {{ props.row.userInfo ? props.row.userInfo.position.position_name : '' }}</p>
                  <p>Phone: {{ props.row.userInfo ? props.row.userInfo.phone : '' }}</p>
                  <p>Created At: {{ props.row.created_at }}</p>
                </el-card>
              </div>
            </el-col>
          </el-row>
        </template>
      </el-table-column>
      <el-table-column>
        <template slot-scope="scope">
          <img
            :src="scope.row.userInfo.photo"
            class="img-circle"
            alt="Photo"
            width="40"
            height="40"
          >
        </template>
      </el-table-column>
      <el-table-column prop="name" label="Name" />
      <el-table-column prop="email" label="Email" />
      <el-table-column label="Position">
        <template slot-scope="scope">
          <span
            style="text-transform:capitalize;"
          >{{ scope.row.userInfo ? scope.row.userInfo.position.position_name : '' }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Operations" fixed="right">
        <template slot-scope="scope">
          <el-button size="mini" @click="handleEdit(scope.$index, scope.row.id)">
            <i class="el-icon-edit" />
          </el-button>
          <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row.id)">
            <i class="el-icon-delete" />
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- End of Table -->
    <!-- Pagination -->
    <div
      v-if="usersData && paginate && paginate.total >= paginate.per_page"
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
    <!--Edit Form Dialog -->
    <el-dialog :visible.sync="dialogFormVisible" :title="modalTitle">
      <el-form ref="userForm" :model="userForm">
        <el-form-item
          :rules="[{ required: true, message: 'Name is required'}]"
          label-width="120px"
          label="Name"
          prop="name"
        >
          <el-input v-model.number="userForm.name" />
        </el-form-item>

        <el-form-item
          :rules="[{ required: true, message: 'Email is required'}, { type: 'email', message: 'Email field must be a email'}]"
          label-width="120px"
          label="Email"
          prop="email"
        >
          <el-input v-model="userForm.email" />
        </el-form-item>

        <el-form-item
          :rules="[{ required: true, message: 'Phone is required'}]"
          label-width="120px"
          label="Phone"
          prop="phone"
        >
          <el-input v-model="userForm.phone" />
        </el-form-item>

        <el-form-item
          v-if="whichMethod === 'create'"
          :rules="[{ required: whichMethod === 'create' ? true :false, message: 'Salary is required'},{ type: 'number', message: 'Salary field must be a number'}]"
          label-width="120px"
          label="Salary(TAKA)"
          prop="base_salary"
        >
          <el-input v-model.number="userForm.base_salary" />
        </el-form-item>

        <el-form-item
          :rules="[{ required: true, message: 'Role is required'}]"
          label-width="120px"
          label="Role"
          prop="role"
        >
          <el-select v-model="userForm.role" placeholder="Select a Role">
            <el-option
              v-for="item in roles"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :rules="[{ required: true, message: 'Working Position is required'}]"
          label-width="120px"
          label="Position"
          prop="position"
        >
          <el-select v-model="userForm.position" placeholder="Select a Positions">
            <el-option
              v-for="item in positions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">Cancel</el-button>
        <el-button type="primary" @click="userFormSubmit('userForm')">Confirm</el-button>
      </span>
    </el-dialog>
    <!-- ENd of edit form Dialog -->
  </div>
</template>

<script>
import { EMPLOYEES, EMPLOYEE_CREATE } from '../../const/api'
import { userPositionDrodownJson, roleDropDownJson } from '../../data/utils.js'
import { GET, DELETE, PATCH, POST } from '../../plugins/axios.js'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Salary' }
  },
  data () {
    return {
      usersData: [],
      paginate: {},
      dialogFormVisible: false,
      userIDCurrent: null,
      userIndexCurrent: null,
      currentPage: 1,
      modalTitle: '',
      userForm: {
        name: '',
        email: '',
        position_id: null,
        role: null,
        phone: '',
        base_salary: ''
      },
      positions: null,
      roles: [],
      whichMethod: ''
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    async bootstrapping () {
      await this.getUsers(1)
      this.positions = await userPositionDrodownJson()
      this.roles = await roleDropDownJson()
    },
    async getUsers (page) {
      const { data } = await GET(`${EMPLOYEES}&page=${page}`)
      this.usersData = data.data
      this.paginate = data.meta.pagination
    },
    async handleCurrentChange (val) {
      await this.getUsers(val)
    },

    async handleCreate () {
      this.whichMethod = 'create'
      this.modalTitle = 'NEW EMPLOYEE'
      this.dialogFormVisible = true
      this.userIDCurrent = null
      this.userForm = {}
    },

    async handleEdit (index, userID) {
      this.whichMethod = 'edit'
      this.modalTitle = 'EDIT EMPLOYEE'
      this.dialogFormVisible = true
      this.userIDCurrent = userID
      this.userForm.name = this.usersData[index].name
      this.userForm.email = this.usersData[index].email
      this.userForm.role = this.usersData[index].role
      this.userForm.phone = this.usersData[index].userInfo.phone
      this.userForm.position = this.usersData[index].userInfo.position.position_name
    },

    userFormSubmit (userForm) {
      this.$refs[userForm].validate(async (valid) => {
        try {
          if (valid) {
            let inputData = {
              name: this.userForm.name,
              email: this.userForm.email,
              position_id: this.userForm.position,
              phone: this.userForm.phone,
              role: this.userForm.role,
              base_salary: this.userForm.base_salary
            }
            if (this.whichMethod === 'create') {
              inputData = { ...inputData, base_salary: this.userForm.base_salary }
            }

            if (this.userIDCurrent) {
              await PATCH(`/api/user/${this.userIDCurrent}/update`, inputData)
            } else {
              await POST(EMPLOYEE_CREATE, inputData)
            }
            this.dialogFormVisible = false
            this.getUsers(this.currentPage)
            return true
          } else {
            console.log('error submit!!')
            return false
          }
        } catch (ex) {
          this.dialogFormVisible = false
        }
      })
    },
    handleDelete (index, userID) {
      this.$confirm('This will permanently delete the user. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
        center: true
      }).then(async () => {
        this.usersData.splice(index, 1)
        await DELETE(`/api/user/${userID}`)
        this.$message({
          type: 'success',
          message: 'Delete completed'
        })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled'
        })
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
