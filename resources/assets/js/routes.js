import VueRouter from 'vue-router';

const routes = [
	{ path: '/', redirect: '/order'},
	{ path:'/login',component:require('./components/login/Index')},
	{
		path:'/order',
		component: require('./components/order/Header'),
		children:[
			{path:'/order',component:require('./components/order/Index')},
			{path:'/order/index',component:require('./components/order/Index')},
			{path:'/order/add',component:require('./components/order/Add')},
		]
	},
	{
		path:'/changku',
		component: require('./components/warehouse/Header'),
		children:[
			{path:'/changku',component:require('./components/warehouse/Index')},
			{path:'/changku/index',component:require('./components/warehouse/Index')},
			{path:'/changku/cate',component:require('./components/warehouse/Cate')},
			{path:'/changku/cate/add',component:require('./components/warehouse/AddCate')},
			{path:'/changku/stock/add',component:require('./components/warehouse/AddStock')},
			{path:'/changku/count',component:require('./components/warehouse/Count')},
		]
	},
	{
		path:'/user',
		component: require('./components/user/Header'),
		children:[
			{path:'/user',component:require('./components/user/Index')},
			{path:'/user/index',component:require('./components/user/Index')},
			{path:'/user/add',component:require('./components/user/Add')},
			{path:'/user/alc/:id',component:require('./components/user/Alc')},
		]
	},
	{
		path:'/count',
		component: require('./components/count/Header'),
		children:[
			{path:'/count',component:require('./components/count/Index')},
			{path:'/count/index',component:require('./components/count/Index')},
		]
	}
];


const router = new VueRouter({
	routes
});

export default router;