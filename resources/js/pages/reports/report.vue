<template>
  <div>
    <div
      id="home"
      class="container mt-5"
    >
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body">
            <div class="form-group">
              <input
                id="name"
                v-model="name"
                type="text"
                class="form-control"
                placeholder="Enter name here"
              >
            </div>
            <button
              class="btn btn-primary pl-5 pr-5"
              @click="download"
            >Download PDF</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import jsPDF from 'jspdf';

export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Positions' }
  },
  data () {
    return {
      name: ''
    }
  },
  methods: {
    download () {
      let pdfName = 'test';
      var doc = new jsPDF()
      doc.text(this.name, 10, 10)
      doc.save(pdfName + '.pdf')
    }
  }
}
</script>

<style scoped>
</style>
