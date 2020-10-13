import moment from 'moment'

import Vue from  "vue"

Vue.filter('time',(a)=>{
    return moment(a).format('dddd');
})

Vue.filter('shortContent',(content,length,s) => {

    return content.substring(0, length)+s;

})
Vue.filter('capitalize', (value) =>  {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
})






