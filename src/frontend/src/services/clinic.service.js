import api from 'utils/api';

const getClinic = async (query) => {
  try {
    const req = api
      .get(`/clinics?${new URLSearchParams(query).toString()}`)
      .then(({ data }) => data);
    const { meta, data } = await req;
    return { meta, data };
  } catch (error) {
    console.error('Error fetching clinics. E: ', error);
    return { meta: null, data: [] };
  }
};

const getClinicIds = async (query) => {
  try {
    const response = await api.get(`/clinics?${new URLSearchParams(query).toString()}`);
    const { meta, data } = response.data;

    // Transform the data for Select component
    const selectOptions = data.map((clinic) => ({
      value: clinic.id, // Assuming your API returns 'id'
      label: clinic.name, // Assuming your API returns 'name'
    }));

    return { meta, data: selectOptions };
  } catch (error) {
    console.error('Error fetching clinics IDs. E: ', error);
    return { meta: null, data: [] };
  }
};

const retrieveClinic = async (id) => {
  const req = await api.get(`/clinics/${id}`).then(({ data }) => data.data);
  return req;
};

// const createSpecie = async (data) => {
//   const req = api.post('/clinics', data).then(({ data }) => data.data);
//   return await req;
// };

// const retrieveSpecie = async (id) => {
//   const req = api.get(`/clinics/${id}`).then(({ data }) => data.data);
//   return await req;
// };

// const updateSpecie = async (id, data) => {
//   const req = api.put(`/clinics/${id}`, data).then(({ data }) => data.data);
//   return await req;
// };

// const deleteSpecie = async (id) => {
//   const req = api.delete(`/clinics/${id}`).then(({ data }) => data);
//   const { deleted } = await req;
//   return deleted;
// };

export { getClinic, getClinicIds, retrieveClinic };
