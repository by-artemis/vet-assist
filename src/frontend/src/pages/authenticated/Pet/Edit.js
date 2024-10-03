import { yupResolver } from '@hookform/resolvers/yup';
import React, { useEffect, useState } from 'react';
import { Controller, useForm } from 'react-hook-form';
import { useTranslation } from 'react-i18next';
import { useLocation, useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import { getClinicIds } from 'services/clinic.service';
import { updatePet } from 'services/pet.service';
import { getSpeciesIds } from 'services/species.service';
import * as yup from 'yup';
import {
  Box,
  Card,
  Container,
  Divider,
  FormControl,
  FormControlLabel,
  FormLabel,
  Grid,
  Radio,
  RadioGroup,
  Typography,
} from '@mui/material';
import Button from 'components/atoms/Button';
import DynamicList from 'components/atoms/DynamicList';
import DatePicker from 'components/atoms/Form/DatePicker';
import Select from 'components/atoms/Form/Select';
import TextField from 'components/atoms/Form/TextField';
import errorHandler from 'utils/errorHandler';

export default function Edit() {
  const location = useLocation();
  const pet = location.state?.pet;
  const { t } = useTranslation();
  const [loading, setLoading] = useState(false);
  const [title, setTitle] = useState(null);
  const navigate = useNavigate();

  const [speciesOptions, setSpeciesOptions] = useState([]);
  const [clinicOptions, setClinicOptions] = useState([]);

  // form validation
  const schema = yup.object({
    // basic info
    name: yup.string().required(t('form.required')),
    gender: yup.string().required(t('form.required')),
    species: yup.number().required(t('form.required')),
    breed: yup.string().required(t('form.required')),
    is_microchipped: yup.number().required(t('form.required')),
    // details
    details: yup.object().shape({
      age: yup.string().required(t('form.required')),
      birthdate: yup.string().required(t('form.required')),
      coat: yup.string().nullable(),
      pattern: yup.string().nullable(),
      weight: yup.string().nullable(),
      last_weighed_at: yup.string().nullable(),
      is_disabled: yup.number().nullable(),
    }),
    // vaccination
    vaccines: yup.array().of(
      yup.object({
        clinic_id: yup.number().required(t('form.required')),
        vaccine: yup.string().nullable(),
        last_vaccinated_at: yup.string().nullable(),
      })
    ),
    // deworming
    dewormers: yup.array().of(
      yup.object({
        clinic_id: yup.number().required(t('form.required')),
        dewormer: yup.string().nullable(),
        last_dewormed_at: yup.string().nullable(),
      })
    ),
  });

  const defaultValues = {
    is_microchipped: 0,
    is_disabled: 0,
  };

  const {
    register,
    handleSubmit,
    getValues,
    setValue,
    setError,
    clearErrors,
    reset,
    control,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(schema),
    mode: 'onChange',
    defaultValues: {
      ...defaultValues,
    },
  });

  const [isMicrochipped, setIsMicrochipped] = useState(defaultValues.is_microchipped);
  const [isDisabled, setIsDisabled] = useState(defaultValues.is_disabled);

  const [vaccines, setVaccines] = useState([]);
  const [dewormers, setDewormers] = useState([]);

  useEffect(() => {
    setLoading(false);

    setTitle('Edit Pet');

    fetchSpecies();
    fetchClinics();

    if (pet) {
      // basic info
      setValue('name', pet.name);
      setValue('gender', pet.gender);
      setValue('species', pet.species);
      setValue('breed', pet.breed);
      setValue('is_microchipped', pet.is_microchipped);
      // details
      if (pet.details) {
        setValue('details.age', pet.details.age);
        setValue('details.birthdate', pet.details.birthdate);
        setValue('details.coat', pet.details.coat);
        setValue('details.pattern', pet.details.pattern);
        setValue('details.weight', pet.details.weight);
        setValue('details.last_weighed_at', pet.details.last_weighed_at);
        setValue('details.is_disabled', pet.details.is_disabled);
      }
      // vaccination
      if (pet.vaccines) {
        setVaccines(
          pet.vaccines.map((vaccine) => ({
            clinic_id: vaccine.clinic_id,
            vaccine: vaccine.vaccine,
            last_vaccinated_at: vaccine.last_vaccinated_at,
          }))
        );

        pet.vaccines.forEach((vaccine, index) => {
          setValue(`vaccines.${index}.clinic_id`, vaccine.clinic_id);
          setValue(`vaccines.${index}.vaccine`, vaccine.vaccine);
          setValue(`vaccines.${index}.last_vaccinated_at`, vaccine.last_vaccinated_at);
        });
      }
      // deworming
      if (pet.dewormers) {
        setDewormers(
          pet.dewormers.map((dewormer) => ({
            clinic_id: dewormer.clinic_id,
            dewormer: dewormer.dewormer,
            last_dewormed_at: dewormer.last_dewormed_at,
          }))
        );

        pet.dewormers.forEach((dewormer, index) => {
          setValue(`dewormers.${index}.clinic_id`, dewormer.clinic_id);
          setValue(`dewormers.${index}.dewormer`, dewormer.dewormer);
          setValue(`dewormers.${index}.last_dewormed_at`, dewormer.last_dewormed_at);
        });
      }

      setIsMicrochipped(pet.is_microchipped);
      setIsDisabled(pet.details.is_disabled);
    }
  }, [pet]);

  // const handleVaccineChange = (e, vaccineIndex, fieldIndex) => {
  const handleVaccineChange = (e, vaccineIndex) => {
    const updatedVaccines = [...vaccines];
    const fieldName = e.target.name.split('.')[2]; // Extract field name (vaccine, last_vaccinated_at, etc.)
    updatedVaccines[vaccineIndex][fieldName] = e.target.value;
    setVaccines(updatedVaccines);
    setValue(e.target.name, e.target.value); // Update the form value using setValue
  };

  const addVaccineRow = () => {
    setVaccines([
      ...vaccines,
      {
        clinic_id: '',
        vaccine: '',
        last_vaccinated_at: '',
      },
    ]);
  };

  const removeVaccineRow = (vaccineIndex) => {
    const updatedVaccines = [...vaccines];
    updatedVaccines.splice(vaccineIndex, 1);
    setVaccines(updatedVaccines);
  };

  // const handleDewormerChange = (e, dewormerIndex, fieldIndex) => {
  const handleDewormerChange = (e, dewormerIndex) => {
    const updatedDewormers = [...dewormers];
    const fieldName = e.target.name.split('.')[2]; // Extract field name (vaccine, last_vaccinated_at, etc.)
    updatedDewormers[dewormerIndex][fieldName] = e.target.value;
    setDewormers(updatedDewormers);
    setValue(e.target.name, e.target.value); // Update the form value using setValue
  };

  const addDewormerRow = () => {
    setDewormers([
      ...dewormers,
      {
        clinic_id: '',
        dewormer: '',
        last_dewormed_at: '',
      },
    ]);
  };

  const removeDewormerRow = (dewormerIndex) => {
    const updatedDewormers = [...dewormers];
    updatedDewormers.splice(dewormerIndex, 1);
    setDewormers(updatedDewormers);
  };

  const fetchSpecies = async () => {
    const { data } = await getSpeciesIds();
    setSpeciesOptions(data);
  };

  const fetchClinics = async () => {
    const { data } = await getClinicIds();
    setClinicOptions(data);
  };

  const handleIsMicrochippedRadioGroupOnChange = (e) => {
    const { value } = e.target;
    setIsMicrochipped(value);
    setValue('is_microchipped', value);
  };

  const handleIsDisabledRadioGroupOnChange = (e) => {
    const { value } = e.target;
    setIsDisabled(value);
    setValue('is_disabled', value);
  };

  const handleFormSubmit = async (data) => {
    setLoading(true);

    try {
      await updatePet(pet.id, data);
      reset();
      clearErrors();
      setLoading(false);
      handleRedirect();
    } catch (err) {
      errorHandler(err, setError, toast);
    }
  };

  const handleRedirect = () => {
    navigate(`/pets`);
  };

  const handleBirthdateOnChange = (value) => {
    const date = value?.format('YYYY-MM-DD') ?? '';
    setValue('birthdate', date, { shouldValidate: true });
  };

  const handleLastWeighedOnChange = (value) => {
    const date = value?.format('YYYY-MM-DD') ?? '';
    setValue('last_weighed_at', date, { shouldValidate: true });
  };

  const handleLastVaccinatedOnChange = (value) => {
    const date = value?.format('YYYY-MM-DD') ?? '';
    setValue('last_vaccinated_at', date, { shouldValidate: true });
  };

  const handleLastDewormedOnChange = (value) => {
    const date = value?.format('YYYY-MM-DD') ?? '';
    setValue('last_dewormed_at', date, { shouldValidate: true });
  };

  const genderOptions = [
    { value: 'male', label: 'Male' },
    { value: 'female', label: 'Female' },
  ];

  return (
    <Container maxWidth="xl" sx={{ pt: 6 }}>
      <Typography variant="h4" component="h4" sx={{ fontWeight: 'bold', mb: 2 }} align="left">
        {title}
      </Typography>
      <form onSubmit={handleSubmit(handleFormSubmit)}>
        <Typography color="text.secondary" variant="h6" component="h6" sx={{ mb: 2 }} align="left">
          Basic Information
        </Typography>
        <Card sx={{ pt: 2, mb: 2 }}>
          <Grid container spacing={2} sx={{ p: 2 }}>
            <Grid item md={6}>
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
                defaultValue={''}
                render={({ field }) => (
                  <Select {...field} label={'Gender'} options={genderOptions} />
                )}
              />
            </Grid>
            <Grid item md={6}>
              <Controller
                name="species"
                control={control}
                defaultValue={''}
                render={({ field }) => (
                  <Select {...field} label={'Species'} options={speciesOptions} />
                )}
              />
            </Grid>
            <Grid item md={6}>
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
              <FormControl>
                <FormLabel
                  error={errors && errors.is_microchipped}
                  sx={{
                    textTransform: 'uppercase',
                    fontWeight: 700,
                    letterSpacing: 1,
                    fontSize: 12,
                  }}
                >
                  Is Microchipped?
                </FormLabel>
                <RadioGroup
                  row
                  label="Is Microchipped?"
                  {...register('is_microchipped')}
                  value={isMicrochipped}
                  onChange={handleIsMicrochippedRadioGroupOnChange}
                >
                  <FormControlLabel value={1} control={<Radio />} label="Yes" />
                  <FormControlLabel value={0} control={<Radio />} label="No" />
                </RadioGroup>
              </FormControl>
            </Grid>
          </Grid>
        </Card>
        <Typography color="text.secondary" variant="h6" component="h6" sx={{ mb: 2 }} align="left">
          Details
        </Typography>
        <Card sx={{ pt: 2, mb: 2 }}>
          <Grid container spacing={2} sx={{ p: 2 }}>
            <Grid item md={6}>
              <TextField
                {...register('details.age')}
                error={errors?.details && errors?.details?.age ? true : false}
                helperText={errors?.details ? errors?.details?.age?.message : null}
                fullWidth
                label="Age"
                name="age"
                type="text"
                size="small"
              />
            </Grid>
            <Grid item md={6}>
              <DatePicker
                {...register('details.birthdate')}
                value={getValues('details.birthdate')}
                label="Birthdate"
                onChange={handleBirthdateOnChange}
                format="YYYY-MM-DD"
                error={errors?.details?.birthdate && Boolean(errors?.details?.birthdate)}
                helperText={errors?.details ? errors?.details?.birthdate?.message : null}
              />
            </Grid>
            <Grid item md={6}>
              <TextField
                {...register('details.coat')}
                error={errors?.details && errors?.details?.coat ? true : false}
                helperText={errors?.details ? errors?.details?.coat?.message : null}
                fullWidth
                label="Coat"
                name="coat"
                type="text"
                size="small"
              />
            </Grid>
            <Grid item md={6}>
              <TextField
                {...register('details.pattern')}
                error={errors?.details && errors?.details?.pattern ? true : false}
                helperText={errors?.details ? errors?.details?.pattern?.message : null}
                fullWidth
                label="Pattern"
                name="pattern"
                type="text"
                size="small"
              />
            </Grid>
            <Grid item md={6}>
              <TextField
                {...register('details.weight')}
                error={errors?.details && errors?.details?.weight ? true : false}
                helperText={errors?.details ? errors?.details?.weight?.message : null}
                fullWidth
                label="Weight"
                name="weight"
                type="text"
                size="small"
              />
            </Grid>
            <Grid item md={6}>
              <DatePicker
                {...register('details.last_weighed_at')}
                value={getValues('details.last_weighed_at')}
                label="Last Weighed Date"
                name="last_weighed_at"
                onChange={handleLastWeighedOnChange}
                format="YYYY-MM-DD"
                error={
                  errors?.details?.last_weighed_at && Boolean(errors?.details?.last_weighed_at)
                }
                helperText={errors?.details ? errors?.details?.last_weighed_at?.message : null}
              />
            </Grid>
            <Grid item md={12}>
              <FormControl>
                <FormLabel
                  error={errors?.details && errors?.details?.is_disabled}
                  sx={{
                    textTransform: 'uppercase',
                    fontWeight: 700,
                    letterSpacing: 1,
                    fontSize: 12,
                  }}
                >
                  Is Disabled?
                </FormLabel>
                <RadioGroup
                  row
                  label="Is Disabled?"
                  {...register('details.is_disabled')}
                  value={isDisabled}
                  onChange={handleIsDisabledRadioGroupOnChange}
                >
                  <FormControlLabel value={1} control={<Radio />} label="Yes" />
                  <FormControlLabel value={0} control={<Radio />} label="No" />
                </RadioGroup>
              </FormControl>
            </Grid>
          </Grid>
        </Card>
        <Typography color="text.secondary" variant="h6" component="h6" sx={{ mb: 2 }} align="left">
          Vaccination & Deworming
        </Typography>
        <Card sx={{ pt: 2, mb: 2 }}>
          {!loading && (
            <Grid container spacing={2} sx={{ p: 2 }}>
              <DynamicList
                data={vaccines.map((vaccine, index) => [
                  {
                    label: 'Vaccine',
                    value: vaccine?.vaccine,
                    name: `vaccines.${index}.vaccine`,
                    error: errors?.vaccines && errors?.vaccines?.[index]?.vaccine ? true : false,
                    helperText: errors?.vaccines
                      ? errors?.vaccines?.[index]?.vaccine.message
                      : null,
                    handleOnChange: handleVaccineChange,
                  },
                  {
                    label: 'Last Vaccinated At',
                    value: vaccine?.last_vaccinated_at,
                    name: `vaccines.${index}.last_vaccinated_at`,
                    type: 'date',
                    error:
                      errors?.vaccines?.[index]?.last_vaccinated_at &&
                      Boolean(errors.vaccines?.[index]?.last_vaccinated_at),
                    helperText: errors?.vaccines?.[index]?.last_vaccinated_at?.message || null,
                    handleOnChange: handleLastVaccinatedOnChange,
                  },
                  {
                    label: 'Clinic',
                    value: vaccine?.clinic_id,
                    name: `vaccines.${index}.clinic_id`,
                    type: 'select',
                    control: control,
                    options: clinicOptions,
                    // handleOnChange: handleDewormerChange,
                  },
                ])}
                // handleOnChange={handleVaccineChange}
                addRow={addVaccineRow}
                removeRow={removeVaccineRow}
              />
              <Grid item md={12} sx={{ mt: 2, mb: 1 }}>
                <Divider />
              </Grid>
              <DynamicList
                data={dewormers.map((dewormer, index) => [
                  {
                    label: 'Dewormer',
                    value: dewormer?.dewormer,
                    name: `dewormers.${index}.dewormer`,
                    error: errors?.dewormers && errors?.dewormers?.[index]?.dewormer ? true : false,
                    helperText: errors?.dewormers
                      ? errors?.dewormers?.[index]?.dewormer.message
                      : null,
                    handleOnChange: handleDewormerChange,
                  },
                  {
                    label: 'Last Dewormed At',
                    value: dewormer?.last_dewormed_at,
                    name: `dewormers.${index}.last_dewormed_at`,
                    type: 'date',
                    error:
                      errors?.dewormers?.[index]?.last_dewormed_at &&
                      Boolean(errors.dewormers?.[index]?.last_dewormed_at),
                    helperText: errors?.dewormers?.[index]?.last_dewormed_at?.message || null,
                    handleOnChange: handleLastDewormedOnChange,
                  },
                  {
                    label: 'Clinic',
                    value: dewormer?.clinic_id,
                    name: `dewormers.${index}.clinic_id`,
                    type: 'select',
                    control: control,
                    options: clinicOptions,
                    // handleOnChange: handleDewormerChange,
                  },
                ])}
                addRow={addDewormerRow}
                removeRow={removeDewormerRow}
              />
            </Grid>
          )}
        </Card>
        <Box sx={{ width: '100%', display: 'flex', justifyContent: 'end', pb: 2, gap: 1 }}>
          <Button type="button" color="warning" onClick={handleRedirect} variant="outlined">
            <Typography sx={{ fontWeight: '900' }}>{t('labels.cancel')}</Typography>
          </Button>
          <Button disabled={loading} type="submit">
            {pet ? t('labels.update') : t('labels.save')}
          </Button>
        </Box>
      </form>
    </Container>
  );
}
