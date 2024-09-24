import api from 'utils/api';

const getSpecies = async (query) => {
  const req = api.get(`/species?${new URLSearchParams(query).toString()}`).then(({ data }) => data);
  const { meta, data } = await req;
  return { meta, data };
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

export { getSpecies };
