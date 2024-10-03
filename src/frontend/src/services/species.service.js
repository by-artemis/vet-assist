import api from 'utils/api';

const getSpecies = async (query) => {
  try {
    const req = api
      .get(`/species?${new URLSearchParams(query).toString()}`)
      .then(({ data }) => data);
    const { meta, data } = await req;
    return { meta, data };
  } catch (error) {
    console.error('Error fetching species. E: ', error);
    return { meta: null, data: [] };
  }
};

const getSpeciesIds = async (query) => {
  try {
    const response = await api.get(`/species?${new URLSearchParams(query).toString()}`);
    const { meta, data } = response.data;

    // Transform the data for Select component
    const selectOptions = data.map((species) => ({
      value: species.id, // Assuming your API returns 'id'
      label: species.name, // Assuming your API returns 'name'
    }));

    return { meta, data: selectOptions };
  } catch (error) {
    console.error('Error fetching species IDs. E: ', error);
    return { meta: null, data: [] };
  }
};

const retrieveSpecies = async (id) => {
  const req = await api.get(`/species/${id}`).then(({ data }) => data.data);
  return req;
};

// const createSpecie = async (data) => {
//   const req = api.post('/species', data).then(({ data }) => data.data);
//   return await req;
// };

// const retrieveSpecie = async (id) => {
//   const req = api.get(`/species/${id}`).then(({ data }) => data.data);
//   return await req;
// };

// const updateSpecie = async (id, data) => {
//   const req = api.put(`/species/${id}`, data).then(({ data }) => data.data);
//   return await req;
// };

// const deleteSpecie = async (id) => {
//   const req = api.delete(`/species/${id}`).then(({ data }) => data);
//   const { deleted } = await req;
//   return deleted;
// };

export { getSpecies, getSpeciesIds, retrieveSpecies };
