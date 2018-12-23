<template>
  <div>
    <card title="Holidays">
      <full-calendar
        ref="calendar"
        :config="config"
        :events="events"
        @view-render="viewRender"
        @day-click="dayClick"
        @event-selected="eventSelected"
      />
    </card>

    <el-dialog :title="holidayModalTitle" :visible.sync="holidayFormDialogOpen" width="35%" center>
      <el-form ref="holidayForm" label-position="left" :model="holidayForm">
        <el-form-item
          :rules="[{ required: true, message: 'Occasion is required'}]"
          label="Holiday Occasion"
          prop="occasion"
        >
          <el-select
            v-model="holidayForm.occasion"
            filterable
            allow-create
            default-first-option
            placeholder="Select or Create a Occation"
          >
            <el-option
              v-for="item in occations"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item
          :rules="[{ required: true, message: 'Holiday For User is required'}]"
          label="Holiday For User"
          prop="holiday_for"
        >
          <el-select
            v-model="holidayForm.holiday_for"
            filterable
            default-first-option
            placeholder="Please Select"
          >
            <el-option
              v-for="item in usersDropdown"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-row>
          <el-col :span="12">
            <el-form-item label="Background Color" prop="background_color">
              <el-color-picker
                v-model="holidayForm.background_color"
                show-alpha
                :predefine="predefineColors"
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Text Color" prop="text_color">
              <el-color-picker
                v-model="holidayForm.text_color"
                show-alpha
                :predefine="predefineColors"
              />
            </el-form-item>
          </el-col>
        </el-row>

        <el-input v-model.number="currentDayClicked" disabled />
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button v-if="currentHolidayID" type="danger" @click="handleDelete()">
          <i class="el-icon-delete" /> Delete
        </el-button>
        <el-button @click="holidayFormDialogOpen = false">Cancel</el-button>
        <el-button type="primary" @click="holidayFormSubmit('holidayForm')">Confirm</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import moment from 'moment'
import FullCalendar from '../../components/Fullcalendar'
import { PATCH, POST, GET, DELETE } from '../../plugins/axios'
import { HOLIDAYS } from '../../const/api'
import { holidayDropdownJson, predefineColors } from '../../data/json.js'
import { userDropDownJsonWithAll } from '../../data/utils.js'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Holidays' }
  },
  components: {
    FullCalendar
  },
  data () {
    return {
      holidayFormDialogOpen: false,
      currentDayClicked: moment().format('YYYY-MM-DD'),
      holidayForm: {
        occasion: '',
        text_color: '',
        background_color: '',
        holiday_for: null
      },
      holidayModalTitle: '',
      currentHolidayID: null,
      occations: holidayDropdownJson,
      usersDropdown: [],
      predefineColors: predefineColors,
      curentDate: moment().format('YYYY-MM-DD'),
      // calendar
      events: [],
      config: {
        weekends: true,
        defaultView: 'month',
        weekNumbers: true,
        navLinks: true,
        editable: true,
        eventLimit: true,
        header: {
          left: 'prevYear,prev,next,nextYear today',
          center: 'title',
          right: 'month,basicWeek,listMonth'
        }
      }
    }
  },
  // created () {
  //   this.boottrapping()
  // },
  methods: {
    async boottrapping () {
      await this.getAllHolidays()
    },
    async getAllHolidays () {
      const { data } = await GET(HOLIDAYS, { date: this.curentDate })
      this.events = data
    },
    async dayClick (date, jsEvent, view) {
      this.usersDropdown = await userDropDownJsonWithAll()
      this.holidayFormDialogOpen = true
      this.holidayModalTitle = 'Create New Holiday'
      this.currentDayClicked = date.format()
      this.holidayForm.occasion = ''
      this.holidayForm.holiday_for = null
      this.currentHolidayID = null
      console.log('clicked ondd w' + date.format())
    },
    async eventSelected (event, jsEvent, view) {
      this.usersDropdown = await userDropDownJsonWithAll()
      this.currentDayClicked = event.start.format()
      this.holidayFormDialogOpen = true
      this.holidayModalTitle = 'Holiday Details'
      this.holidayForm.occasion = event.original_title
      this.holidayForm.holiday_for = event.holiday_for
      this.holidayForm.background_color = event.color
      this.holidayForm.text_color = event.textColor
      this.currentHolidayID = event.holiday_id
      console.log('Event clicked on', event.title)
    },
    holidayFormSubmit (holidayForm) {
      this.$refs[holidayForm].validate(async (valid) => {
        if (valid) {
          let inputData = {
            date: this.currentDayClicked,
            occasion: this.holidayForm.occasion,
            background_color: this.holidayForm.background_color,
            text_color: this.holidayForm.text_color,
            holiday_for: this.holidayForm.holiday_for
          }
          if (this.currentHolidayID) {
            await PATCH(`/api/holiday/${this.currentHolidayID}/update`, inputData)
          } else {
            await POST('/api/holiday-create', inputData)
          }
          this.getAllHolidays()
          this.holidayFormDialogOpen = false
          return true
        } else {
          console.log('error submit in holiday!!')
          return false
        }
      })
    },

    handleDelete () {
      this.$confirm('This will permanently delete the holiday. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
        center: true
      }).then(async () => {
        await DELETE(`/api/holiday/${this.currentHolidayID}`)
        this.getAllHolidays()
        this.holidayFormDialogOpen = false
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
    },
    // work as created cycle
    viewRender (view, element) {
      var b = this.$refs.calendar.fireMethod('getDate')
      this.curentDate = b.format('YYYY-MM-DD')
      console.log(b.format('YYYY-MM-DD'))
      this.getAllHolidays()
    }
  }
}
</script>
