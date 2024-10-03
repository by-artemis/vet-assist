import { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import { deletePet, retrievePet, searchPets } from 'services/pet.service';
import Box from '@mui/material/Box';
import DataTable from 'components/molecules/DataTable';
import { criteria, meta as defaultMeta } from 'config/search';

function Index() {
  const { t } = useTranslation();
  const [data, setData] = useState([]);
  const [query, setQuery] = useState(criteria);
  const [meta, setMeta] = useState(defaultMeta);
  const navigate = useNavigate();

  const fetchPets = async () => {
    const { meta, data } = await searchPets(query);
    const transformedData = data.map((pet) => ({
      ...pet,
      is_microchipped: pet.is_microchipped ? 'Yes' : 'No',
    }));

    setMeta({ ...meta, meta }); // This line seems redundant, you might want to check it
    setData(transformedData); // Set the transformed data to your state
  };

  useEffect(() => {
    fetchPets();
  }, [query]);

  const headers = [
    {
      id: 'name',
      numeric: false,
      disablePadding: false,
      label: 'Name',
    },
    {
      id: 'gender',
      numeric: false,
      disablePadding: false,
      label: 'Gender',
    },
    {
      id: 'species',
      numeric: false,
      disablePadding: false,
      label: 'Species',
    },
    {
      id: 'breed',
      numeric: false,
      disablePadding: false,
      label: 'Breed',
    },
    {
      id: 'is_microchipped',
      numeric: false,
      disablePadding: false,
      label: 'Microchipped',
    },
  ];

  const handleChangePage = (event, value) => {
    setQuery({ ...query, ...{ page: value } });
  };

  const handleSort = (event, { order, sort }) => {
    setQuery({ ...query, ...{ order, sort } });
  };

  const handleSearch = (keyword) => {
    setQuery({ ...query, ...{ keyword, page: 1 } });
  };

  const handleEdit = async (id) => {
    const pet = await retrievePet(id);
    navigate(`/pets/edit/${id}`, { state: { pet: pet } });
  };

  const handleDelete = async (id) => {
    if (confirm(t('pages.users.delete_confirmation'))) {
      await deletePet(id);
      fetchPets();
      toast(t('pages.users.user_deleted'), { type: 'success' });
    }
  };

  const handleAdd = () => {
    navigate(`/pets/create`);
  };

  return (
    <Box>
      <DataTable
        header={headers}
        data={data}
        page={query.page}
        total={meta.lastPage}
        order={query.order}
        sort={query.sort}
        handleChangePage={handleChangePage}
        handleSort={handleSort}
        handleSearch={handleSearch}
        handleEdit={handleEdit}
        handleDelete={handleDelete}
        handleAdd={handleAdd}
      />
      {/* <AddEditModal
        open={open}
        pet={pet}
        handleSaveEvent={handleSaveEvent}
        handleClose={() => setOpen(false)}
      /> */}
    </Box>
  );
}

export default Index;
