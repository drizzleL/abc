<!DOCTYPE html>
<html>
<head>
	<title></title>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style type="text/css">
.container {
  flex-direction: column;
  display: flex;
}
</style>
</head>
<body>
<div id="example"></div>
<div class="container">
</div>
<script type="text/javascript">

let getJobInfo = (job_id) => {
  return axios.get('/api/jobs/'+job_id);
    // .then(function (response) {
    // 	console.log(response);
    // 	getCompanyInfo(response.data.company_id);
    // })
    // .catch(function (error) {
    //   console.log(error);
    // });
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

let starsth = () => {
  axios.post('/api/jobs/587/star', {
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

let showJobDetail = (job_id) => {
  getJobInfo(job_id)
    .then(function(response){
      var data = response.data;
      writeToDiv('id:'+data.id+'<br>name:'+data.name+'<div onClick="getCompanyDetail(122)">Back</div>');
      console.log(data);
    });
}

//showJobDetail(587);
 writeToDiv('loading');
 setTimeout(function(){getCompanyDetail(122)}, 500);
</script>
</body>
</html>