<template>
  <div class="container">
    <b-row>
      <b-col md="4">
        <b-card title="Event">
          <b-form>
            <b-form-group id="input-group-1" label="Title:" label-for="input-1">
              <b-form-input
                id="input-1"
                v-model="eventForm.title"
                placeholder="Enter Title"
                required
              ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="From:" label-for="input-2">
              <datepicker
                @selected="highlightFrom"
                :highlighted="dateHighlighted"
                :disabledDates="disabledDates"
                input-class="form-control"
                placeholder="Start date"
                v-model="eventForm.from"
              ></datepicker>
            </b-form-group>

            <b-form-group id="input-group-3" label="To:" label-for="input-3">
              <datepicker
                @selected="highlightTo"
                :highlighted="dateHighlighted"
                :disabledDates="disabledDates"
                input-class="form-control"
                placeholder="End date"
                v-model="eventForm.to"
              ></datepicker>
            </b-form-group>

            <b-form-group label="Target Days:">
              <b-form-checkbox-group id="checkbox-group-1">
                <b-form-checkbox
                  v-for="(day, index) in weekDays"
                  :value="day"
                  :key="index"
                  v-model="eventForm.selectedDays"
                >{{ day }}</b-form-checkbox>
              </b-form-checkbox-group>
            </b-form-group>

            <b-button variant="success" @click.prevent="submitEvent">Submit</b-button>
          </b-form>
        </b-card>
      </b-col>
      <b-col md="8">
        <h2>{{ currentDate | formatToMonthName }}</h2>
        <b-list-group>
          <b-list-group-item
            v-for="(day, index) in monthDays"
            :key="index"
          >{{ day | formatToDateDay }}</b-list-group-item>
        </b-list-group>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import { eachDay, startOfMonth, endOfMonth, format } from "date-fns";
const CURRENT_DATE = new Date();

export default {
  mounted() {
    console.log("Component mounted.");
  },

  components: {
    Datepicker
  },

  data() {
    return {
      eventForm: {
        title: "",
        from: "",
        to: "",
        selectedDays: []
      },
      dateHighlighted: {
        to: "",
        from: "",
        includeDisabled: true
      },
      disabledDates: {
        to: ""
      },
      weekDays: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
      currentDate: CURRENT_DATE,
      monthDays: eachDay(startOfMonth(CURRENT_DATE), endOfMonth(CURRENT_DATE))
    };
  },

  methods: {
    highlightFrom(val) {
      this.dateHighlighted.to = this.eventForm.to;
      this.dateHighlighted.from = val;

      this.disabledDates.to = val;
    },

    highlightTo(val) {
      this.dateHighlighted.from = this.eventForm.from;
      this.dateHighlighted.to = val;
    },

    submitEvent() {
      console.log(this.eventForm);
    }
  },

  filters: {
    formatToMonthName: function(value) {
      return value.toLocaleString("default", { month: "long" });
    },

    formatToDateDay: function(value) {
      return format(value, "D ddd");
    }
  }
};
</script>