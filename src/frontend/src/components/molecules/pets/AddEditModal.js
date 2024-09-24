import { yupResolver } from '@hookform/resolvers/yup';
import PropTypes from 'prop-types';
import React, { useEffect, useState } from 'react';
import { Controller, useForm } from 'react-hook-form';
import { useTranslation } from 'react-i18next';
import { toast } from 'react-toastify';
import { createPet, updatePet } from 'services/pet.service';
import { getSpecies } from 'services/species.service';
import * as yup from 'yup';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import Button from 'components/atoms/Button';
import RadioGroup from 'components/atoms/Form/RadioGroup';
import Select from 'components/atoms/Form/Select';
import TextField from 'components/atoms/Form/TextField';
import Modal from 'components/organisms/Modal';
import errorHandler from 'utils/errorHandler';

AddEditModal.propTypes = {
  open: PropTypes.bool,
  pet: PropTypes.object,
  handleSaveEvent: PropTypes.func,
  handleClose: PropTypes.func,
};

export default function AddEditModal(props) {
  const { pet, open, handleClose, handleSaveEvent } = props;

  const { t } = useTranslation();
  const [loading, setLoading] = useState(false);
  const [title, setTitle] = useState(null);
  const [species, setSpecies] = useState([]);

  // form validation
  const schema = yup.object({
    name: yup.string().required(t('form.required')),
    gender: yup.string().required(t('form.required')),
    species: yup.string().required(t('form.required')),
    breed: yup.string().required(t('form.required')),
    is_microchipped: yup.string().required(t('form.required')),
  });

  const {
    register,
    handleSubmit,
    setValue,
    setError,
    clearErrors,
    reset,
    control,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(schema),
  });

  useEffect(() => {
    setLoading(false);

    setTitle('Add Pet');
    setValue('name', '');
    setValue('gender', '');
    setValue('species', '');
    setValue('breed', '');
    setValue('is_microchipped', '');

    if (pet) {
      // pre-fill the form
      setTitle('Edit Pet');
      setValue('name', pet.name);
      setValue('gender', pet.gender);
      setValue('species', pet.species);
      setValue('breed', pet.breed);
      setValue('is_microchipped', pet.is_microchipped);
    }
  }, [pet]);

  useEffect(() => {
    if (!open) clearErrors();
    else fetchSpecies();
  }, [open]);

  const fetchSpecies = async () => {
    const { data } = await getSpecies();
    setSpecies(() =>
      data.map((specie) => ({
        label: specie.name,
        value: specie.name,
      }))
    );
  };

  const handleFormSubmit = async (data) => {
    setLoading(true);
    console.log(data);

    try {
      const response = pet ? await updatePet(pet.id, data) : await createPet(data);
      reset();
      setLoading(false);
      handleSaveEvent(response);
    } catch (err) {
      errorHandler(err, setError, toast);
    }
  };

  const genderOptions = [
    { value: 'male', label: 'Male' },
    { value: 'female', label: 'Female' },
  ];

  return (
    <Modal open={open} handleClose={handleClose} title={title}>
      <Box sx={{ pt: 2 }}>
        <form onSubmit={handleSubmit(handleFormSubmit)}>
          <Grid container spacing={2} sx={{ p: 2 }}>
            <Grid item md={12}>
              <TextField
                {...register('name')}
                error={errors && errors.name ? true : false}
                helperText={errors ? errors?.name?.message : null}
                fullWidth
                label="Name"
                name="name"
                type="text"
                size="small"
              />
            </Grid>
            <Grid item md={6}>
              <Controller
                name="gender"
                control={control}
                render={({ field }) => (
                  <Select {...field} label={'Gender'} options={genderOptions} />
                )}
              />
            </Grid>
            <Grid item md={6}>
              <Controller
                name="species"
                control={control}
                render={({ field }) => <Select {...field} label={'Species'} options={species} />}
              />
            </Grid>
            <Grid item md={12}>
              <TextField
                {...register('breed')}
                error={errors && errors.breed ? true : false}
                helperText={errors ? errors?.breed?.message : null}
                fullWidth
                label="Breed"
                name="breed"
                type="text"
                size="small"
              />
            </Grid>
            <Grid item md={12}>
              <RadioGroup
                label="Is Microchipped?"
                options={[
                  { label: 'Yes', value: 'Yes' },
                  { label: 'No', value: 'No' },
                ]}
                inline={true}
                {...register('is_microchipped')}
                error={errors && errors.is_microchipped ? true : false}
                helperText={errors ? errors?.is_microchipped?.message : null}
              />
            </Grid>
          </Grid>

          <Box sx={{ width: '100%', display: 'flex', justifyContent: 'end', px: 2, pb: 2, gap: 1 }}>
            <Button onClick={handleClose} variant="outlined" disabled={loading}>
              {t('labels.cancel')}
            </Button>

            <Button disabled={loading} type="submit">
              {pet ? t('labels.update') : t('labels.save')}
            </Button>
          </Box>
        </form>
      </Box>
    </Modal>
  );
}
