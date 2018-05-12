<template>
	<li class="dropdown" v-if="notifications.length">
		<a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">
			<span><i class="fas fa-bell"></i></span>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
			<li v-for="notification in notifications">
		    	<a  class="dropdown-item" :href="notification.data.link" v-text="notification.data.message" @click="markAsRead(notification)"></a>
			</li>
		</ul>
	</li>
</template>

<script type="text/javascript">
	export default {

		data(){
			return{ notifications: false}
		},

		created(){
			axios.get("/profiles/" + window.App.user.name + "/notifications")
				.then(response =>this.notifications = response.data);
		},

		methods: {
			markAsRead(notification){
				axios.delete("/profiles/" + window.App.user.name + "/notifications/" + notification.id);
			}
		}

	}
</script>