import api from 'utils/api';

const searchPets = async (query) => {
  const req = api.get(`/pets?${new URLSearchParams(query).toString()}`).then(({ data }) => data);
  const { meta, data } = await req;
  return { meta, data };
};

const createPet = async (data) => {
  const req = api.post('/pets', data).then(({ data }) => data.data);
  return await req;
};

const retrievePet = async (id) => {
  const req = api.get(`/pets/${id}`).then(({ data }) => data.data);
  return await req;
};

const updatePet = async (id, data) => {
  const req = api.put(`/pets/${id}`, data).then(({ data }) => data.data);
  return await req;
};

const deletePet = async (id) => {
  const req = api.delete(`/pets/${id}`).then(({ data }) => data);
  const { deleted } = await req;
  return deleted;
};

export { searchPets, createPet, retrievePet, updatePet, deletePet };
