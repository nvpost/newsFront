
let app = new Vue({
    'el': '#app',
    data() {
        return {
            'mes': 'ni',
            'news': []
        }
    },
    beforeCreate(){
        console.log('hi')

            fetch('server/getData.php')
            .then(res=>res.json())
            .then((data) => {
                this.news = data.data
            })
    },

    methods:{
        d(date){
            return new Date(date)
        }
    }
})