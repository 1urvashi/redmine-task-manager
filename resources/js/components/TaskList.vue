<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Local Tasks</h1>
                <input v-model="search" @input="searchTasks" placeholder="Search tasks" />
                <ul>
                    <li v-for="task in paginatedTasks" :key="task.id">
                    {{ task.title }}
                    <!-- Add other task details -->
                    <button @click="deleteTask(task.id)">Delete</button>
                    </li>
                </ul>
                <pagination :data="tasks" @pagination-change-page="changePage" />
                <hr />
                <h1>Redmine Tasks</h1>
                <ul>
                    <li v-for="redmineTask in redmineTasks" :key="redmineTask.id">
                        {{ redmineTask.subject }}
                    </li>
                </ul>
            </div>
        </div>
  </div>
  </template>

<script>
import axios from 'axios'; // Make sure axios is installed: npm install axios
import RedmineApiService from '@/services/RedmineApiService'; // Update the path based on your project structure

export default {
  data() {
    return {
      tasks: [],
      redmineTasks: [],
      search: '',
      currentPage: 1,
      perPage: 5,
    };
  },
  computed: {
    paginatedTasks() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      return this.filteredTasks.slice(start, end);
    },
    filteredTasks() {
      return this.tasks.filter(task =>
        task.title.toLowerCase().includes(this.search.toLowerCase())
      );
    },
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await axios.get('/api/tasks'); // Assuming you have an API endpoint for tasks
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    searchTasks() {
      this.currentPage = 1;
    },
    changePage(page) {
      this.currentPage = page;
    },
    async deleteTask(taskId) {
      try {
        await axios.delete(`/api/tasks/${taskId}`); // Assuming you have an API endpoint for deleting tasks
        this.fetchTasks(); // Refresh the task list after deletion
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    },
    async fetchRedmineTasks() {
      try {
        const response = await axios.get('/api/redmine-tasks'); // Assuming you have an API endpoint for Redmine tasks
        this.redmineTasks = response.data;
      } catch (error) {
        console.error('Error fetching Redmine tasks:', error);
      }
    },
  },
  mounted() {
    this.fetchTasks();
    this.fetchRedmineTasks();
  },
};
</script>
