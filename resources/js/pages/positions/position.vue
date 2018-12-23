<template>
  <div>
    <!-- New user create -->
    <el-button @click="handleCreate()">
      <i class="el-icon-plus" />
      New Position
    </el-button>
    <!-- End of new user create -->
    <!-- Start of Table -->
    <el-table
      v-if="positionsData"
      :data="positionsData"
      style="width: 100%; margin-top: 20px"
    >
      <el-table-column
        prop="position_name"
        label="Position"
      />
      <el-table-column
        prop="work_hour_per_day"
        label="Work Hour Per Day"
      />
      <el-table-column
        label="Operations"
        fixed="right"
      >
        <template slot-scope="scope">
          <el-button
            size="mini"
            @click="handleEdit(scope.$index, scope.row.id)"
          >
            <i class="el-icon-edit" />
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- End of Table -->
    <!-- Pagination -->
    <div
      v-if="positionsData && paginate && paginate.total >= paginate.per_page"
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
    <el-dialog
      :visible.sync="dialogFormVisible"
      :title="modalTitle"
    >
      <el-form
        ref="positionForm"
        :model="positionForm"
      >
        <el-form-item
          :rules="[{ required: true, message: 'Position is required'}]"
          label-width="120px"
          label="Position"
          prop="position_name"
        >
          <el-input v-model="positionForm.position_name" />
        </el-form-item>

        <el-form-item
          :rules="[{ required: true, message: 'Work Hour-Day is required'}]"
          label-width="120px"
          label="Work Hour-Day"
          prop="work_hour_per_day"
        >
          <el-input v-model.number="positionForm.work_hour_per_day" />
        </el-form-item>
      </el-form>
      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="dialogFormVisible = false">Cancel</el-button>
        <el-button
          type="primary"
          @click="positionFormSubmit('positionForm')"
        >Confirm</el-button>
      </span>
    </el-dialog>
    <!-- ENd of edit form Dialog -->
  </div>
</template>

<script>
import { GET_ALL_POSITIONS } from '../../const/api';
import { GET, PATCH, POST } from '../../plugins/axios.js';
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Positions' }
  },
  data () {
    return {
      positionsData: [],
      paginate: {},
      dialogFormVisible: false,
      positionIDCurrent: null,
      currentPage: 1,
      modalTitle: '',
      positionForm: {
        position_name: '',
        work_hour_per_day: ''
      }
    }
  },
  created () {
    this.bootstrapping()
  },
  methods: {
    async bootstrapping () {
      await this.getPositions(1)
    },
    async getPositions (page) {
      const { data } = await GET(`${GET_ALL_POSITIONS}?page=${page}`)
      this.positionsData = data.data
      this.paginate = data.meta.pagination
    },
    async handleCurrentChange (val) {
      await this.getPositions(val)
    },

    async handleCreate () {
      this.modalTitle = 'NEW POSITION';
      this.dialogFormVisible = true
      this.positionIDCurrent = null
      this.positionForm = {}
    },

    async handleEdit (index, positionID) {
      this.modalTitle = 'EDIT POSITION';
      this.dialogFormVisible = true
      this.positionIDCurrent = positionID
      this.positionForm.position_name = this.positionsData[index].position_name
      this.positionForm.work_hour_per_day = this.positionsData[
        index
      ].work_hour_per_day
    },

    positionFormSubmit (positionForm) {
      this.$refs[positionForm].validate(async valid => {
        try {
          if (valid) {
            let inputData = {
              position: this.positionForm.position_name,
              work_hour_per_day: this.positionForm.work_hour_per_day
            }
            if (this.positionIDCurrent) {
              await PATCH(
                `/api/positions/${this.positionIDCurrent}/update`,
                inputData
              )
            } else {
              await POST(`/api/position`, inputData)
            }
            this.dialogFormVisible = false
            this.getPositions(this.currentPage)
            return true
          } else {
            console.log('error submit!!')
            return false
          }
        } catch (ex) {
          this.dialogFormVisible = false
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
.pagination {
  padding-top: 30px;
  padding-bottom: 30px;
}
</style>
