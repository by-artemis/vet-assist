import api from 'utils/api';
import { retrieveSpecies } from './species.service';

const searchPets = async (query) => {
  const req = api.get(`/pets?${new URLSearchParams(query).toString()}`).then(({ data }) => data);
  const { meta, data } = await req;

  const tableDataPromises = data.map(async (pet) => {
    const species = await retrieveSpecies(pet.species); // Fetch species name asynchronously

    return {
      id: pet.id,
      name: pet.name,
      gender: pet.gender,
      species: species.name,
      breed: pet.breed,
      is_microchipped: pet.is_microchipped,
    };
  });

  const tableData = await Promise.all(tableDataPromises); // Wait for all species names to be fetched

  return { meta, data: tableData };
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
  const req = api.patch(`/pets/${id}`, data).then(({ data }) => data.data);
  return await req;
};

const deletePet = async (id) => {
  const req = api.delete(`/pets/${id}`).then(({ data }) => data);
  const { deleted } = await req;
  return deleted;
};

export { searchPets, createPet, retrievePet, updatePet, deletePet };
