function pipi() {
  console.log('pipi');
}
let getJobInfo = (job_id) => {
  return axios.get('/api/jobs/'+job_id);
}

let getJobList = () => {
  return axios.get('/api/jobs');
}

let getRecordList = () => {
  axios.get('/records')
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
}

let createCompany = () => {
  axios.post('/companies', {
      firstName: 'Fred',
      lastName: 'Flintstone'
    })
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
}

let getCompanyInfo = (company_id) => {
  return axios.get('/api/companies/'+company_id);
}

let getCompanyJobs = (company_id) => {
  return axios.get('/api/companies/'+company_id+'/jobs');
}

let getCompanyDetail = (company_id) => {
  console.log('getCompanyDetail');
  return axios.all([getCompanyInfo(company_id), getCompanyJobs(company_id)])
    .then(axios.spread(function (company, jobs) {
      text = company.data.name+'<div class="container">'+
      jobs.data.data.map(function(job){
        return '<div class="flex-item" onClick=showJobDetail('+job.id+')>'+job.name+'</div>';
      }).join('')+'</div>';
      writeToDiv(text);
    }));
}

let writeToDiv = (html) => {
  document.getElementById('example').innerHTML = html;
}

let showJobDetail = (job_id) => {
  getJobInfo(job_id)
    .then(function(response){
      var data = response.data;
      var starSpan = data.star_status ? 'unstarJob' : 'starJob';
      writeToDiv('id:'+data.id+'<br>name:'+data.name+' <span onClick="'+starSpan+'('+data.id+')">star:'+data.star_status+'</span><div onClick="getCompanyDetail(122)">Back</div>');
      console.log(data);
    });
}

let starJob = (job_id) => {
  axios.post('/api/jobs/'+job_id+'/star')
    .then(function (response) {
      console.log(response);
      alert('star done');
    })
    .catch(function (error) {
      console.log(error);
    });
}

let unstarJob = (job_id) => {
  axios.post('/api/jobs/'+job_id+'/unstar')
    .then(function (response) {
      console.log(response);
      alert('unstar done');
    })
    .catch(function (error) {
      console.log(error);
    });
}

let getClients = () => {
  axios.get('/oauth/clients')
    .then(response => {
        console.log(response.data);
    });
}

let postLead = () => {
  axios.post('/api/leads')
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
}