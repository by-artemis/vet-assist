import { useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import { toast } from 'react-toastify';
import { deletePet, retrievePet, searchPets } from 'services/pet.service';
import Box from '@mui/material/Box';
import DataTable from 'components/molecules/DataTable';
import AddEditModal from 'components/molecules/pets/AddEditModal';
import { criteria, meta as defaultMeta } from 'config/search';

function Index() {
  const { t } = useTranslation();
  const [data, setData] = useState([]);
  const [pet, setPet] = useState(null);
  const [query, setQuery] = useState(criteria);
  const [meta, setMeta] = useState(defaultMeta);
  const [open, setOpen] = useState(false);

  const fetchPets = async () => {
    const { meta, data } = await searchPets(query);
    setMeta({ ...meta, meta });
    setData(data);
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
    setOpen(true);
    setPet(pet);
  };

  const handleDelete = async (id) => {
    if (confirm(t('pages.users.delete_confirmation'))) {
      await deletePet(id);
      fetchPets();
      toast(t('pages.users.user_deleted'), { type: 'success' });
    }
  };

  const handleAdd = () => {
    setPet(null);
    setOpen(true);
  };

  const handleSaveEvent = (response) => {
    if (!pet) {
      fetchPets();
      setOpen(false);
      toast("Pet created successfully!", { type: 'success' });
      return;
    }

    let updatedList = [...data];
    const index = updatedList.findIndex((row) => parseInt(row.id) === parseInt(response.id));

    updatedList[index] = response;

    setData(updatedList);
    setOpen(false);

    toast(t('pages.users.user_updated'), { type: 'success' });
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

      <AddEditModal
        open={open}
        pet={pet}
        handleSaveEvent={handleSaveEvent}
        handleClose={() => setOpen(false)}
      />
    </Box>
  );
}

export default Index;
