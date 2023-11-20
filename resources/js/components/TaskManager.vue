<template>
    <div class="container mt-4">
        <h1 class="mb-4">Task Management</h1>

       <!-- Task search filter -->
       <form @submit.prevent="searchTasks" class="mb-4">
            <div class="form-row">
                <div class="col-md-6">
                    <input v-model="searchQuery" type="text" class="form-control" placeholder="Search tasks">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <!-- Task List -->
        <ul class="list-group">
            <li v-for="task in paginatedTasks" :key="task.id" class="list-group-item">
                {{ task.title }} - {{ task.description }}
                <button @click="deleteTask(task.id)" class="btn btn-danger btn-sm float-right">Delete</button>
            </li>
        </ul>

        <!-- Pagination -->
        <nav aria-label="Page navigation mt-4">
            <ul class="pagination">
                <li class="page-item" :class="{ 'disabled': tasks.current_page === 1 }">
                    <a class="page-link" href="#" @click.prevent="fetchTasks(tasks.current_page - 1)">Previous</a>
                </li>
                <li class="page-item" v-for="page in tasks.last_page" :key="page" :class="{ 'active': page === tasks.current_page }">
                    <a class="page-link" href="#" @click.prevent="fetchTasks(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ 'disabled': tasks.current_page === tasks.last_page }">
                    <a class="page-link" href="#" @click.prevent="fetchTasks(tasks.current_page + 1)">Next</a>
                </li>
            </ul>
        </nav>

        <!-- Task creation form -->
        <form @submit.prevent="createTask" class="mt-4">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="title">Task Title</label>
                    <input v-model="newTask.title" type="text" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="description">Task Description</label>
                    <textarea v-model="newTask.description" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>

    </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      tasks: [], // Fetch tasks from Laravel controller or API
      searchQuery: '',
      currentPage: 1,
      tasksPerPage: 5,
    };
  },
  computed: {
    filteredTasks() {
      return this.tasks.filter(task => task.subject.toLowerCase().includes(this.search.toLowerCase()));
    },
   
    totalPages() {
      return Math.ceil(this.filteredTasks.length / this.tasksPerPage);
    },
    paginatedTasks() {
      const startIndex = (this.currentPage - 1) * this.tasksPerPage;
      const endIndex = startIndex + this.tasksPerPage;
      return this.filteredTasks.slice(startIndex, endIndex);
    },
  },
  methods: {
    async fetchTasks(page) {
        axios.get(`/tasks?page=${page}&search=${this.searchQuery}`)
        .then(response => {
            this.tasks = response.data;
        })
        .catch(error => {
            console.error('Error fetching tasks:', error);
        });
    },
    searchTasks() {
        this.fetchTasks(1);
    },
    changePage(step) {
      this.currentPage += step;
    },
    async deleteTask(taskId) {
      try {
        // Communicate with Laravel controller or API to delete the task
        await axios.delete(`/tasks/${taskId}`); 

        this.tasks = this.tasks.filter(task => task.id !== taskId);

        // Adjust pagination if necessary
        const lastPage = Math.ceil(this.tasks.length / this.tasksPerPage);
        if (this.currentPage > lastPage) {
          this.currentPage = lastPage;
        }
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    },
    async createTask() {
        try {
            const response = await axios.post('/tasks/create', this.newTask);
            const createdTask = response.data;
            this.tasks.push(createdTask);

            // Clear the form after successful creation
            this.newTask = {
                title: '',
                description: '',
            };

            this.$emit('task-created', createdTask);
        } catch (error) {
            console.error('Error creating task:', error);
        }
    },
  },
  mounted() {
    this.fetchTasks();
  },
};
</script>

<style scoped>

div {
  margin: 20px;
}

input {
  padding: 8px;
  margin-bottom: 10px;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  margin-bottom: 10px;
}

nav {
  margin-top: 10px;
}

button {
  padding: 8px;
  cursor: pointer;
  margin-right: 5px;
}

button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
