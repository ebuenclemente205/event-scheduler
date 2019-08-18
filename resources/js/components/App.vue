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
                format="yyyy-MM-dd"
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
                format="yyyy-MM-dd"
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
                  v-model="eventForm.days"
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
          <b-list-group-item v-for="(day, index) in monthDays" :key="index">
            <b-row>
              <b-col md="2">{{ day | formatToDateDay }}</b-col>
              <b-col md="10">
                <small>
                  <div v-for="event in events" :key="event.id">
                    <div v-for="(eventDay, eventDaysKey) in event.eventDays" :key="eventDaysKey">
                      <div v-if="checkEventDayEqual(eventDay, day)">
                        <b-alert v-if="checkDayEqual(event.days, day)" show variant="dark">
                          <span>{{ event.title }}</span>
                        </b-alert>
                      </div>
                    </div>
                  </div>
                </small>
              </b-col>
            </b-row>
          </b-list-group-item>
        </b-list-group>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import { isEqual, eachDay, startOfMonth, endOfMonth, format } from "date-fns";
import axios from "axios";
const CURRENT_DATE = new Date();

export default {
  components: {
    Datepicker
  },

  data() {
    return {
      eventForm: {
        title: "",
        from: "",
        to: "",
        days: []
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
      monthDays: eachDay(startOfMonth(CURRENT_DATE), endOfMonth(CURRENT_DATE)),
      events: [],
      formatToDateDay: function() {},
      formatToDay: function() {}
    };
  },

  mounted() {
    let url = "/api/events";
    axios.get(url).then(response => {
      let eventResponse = response.data.data;

      eventResponse.forEach(event => {
        event.eventDays = eachDay(event.from, event.to);
        this.events.push(event);
      });
    });
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

    submitEvent(event) {
      let url = "/api/events";
      axios.post(url, this.eventForm).then(response => {
        let eventResponse = response.data.data;
        eventResponse.eventDays = eachDay(eventResponse.from, eventResponse.to);
        this.events.push(eventResponse);
      });
    },

    checkDayEqual(chosenDays, day) {
      return chosenDays.indexOf(format(day, "ddd")) > -1;
    },

    checkEventDayEqual(eventDay, day) {
      return isEqual(eventDay, day);
    }
  },

  filters: {
    formatToMonthName: function(value) {
      return value.toLocaleString("default", { month: "long" });
    },

    formatToDateDay: function(value) {
      return format(value, "D ddd");
    },

    formatToDay: function(value) {
      return format(value, "ddd");
    }
  }
};
</script>