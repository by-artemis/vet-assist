import PropTypes from 'prop-types';
import React from 'react';
import { Controller } from 'react-hook-form';
import { Add, Remove } from '@mui/icons-material';
import Grid from '@mui/material/Grid';
import DatePicker from 'components/atoms/Form/DatePicker';
import Select from 'components/atoms/Form/Select';
import TextField from 'components/atoms/Form/TextField';

function DynamicList(props) {
  const { data, addRow, removeRow } = props;

  return (
    <>
      {data.map((items, i1) => (
        <Grid container spacing={2} sx={{ p: 2 }} key={i1}>
          {items.map((item, i2) => {
            if (item.type === 'date') {
              return (
                <Grid item md={3} key={i2}>
                  <DatePicker
                    name={item.name}
                    value={item.value}
                    label={item.label}
                    format="YYYY-MM-DD"
                    error={item.error}
                    helperText={item.helperText}
                    onChange={(e) => item.handleOnChange(e, i1, i2)}
                  />
                </Grid>
              );
            } else if (item.type === 'select') {
              return (
                <Grid item md={3} key={i2}>
                  <Controller
                    name={item.name}
                    control={item.control}
                    defaultValue={''}
                    render={({ field }) => (
                      <Select {...field} value={''} label={item.label} options={item.options} />
                    )}
                  />
                </Grid>
              );
            } else {
              return (
                <Grid item md={4} key={i2}>
                  <TextField
                    name={item.name}
                    value={item.value}
                    error={item.error}
                    helperText={item.helperText}
                    fullWidth
                    label={item.label}
                    type="text"
                    size="small"
                    onChange={(e) => item.handleOnChange(e, i1, i2)}
                  />
                </Grid>
              );
            }
          })}
          <Grid item md={2} sx={{ display: 'flex', alignItems: 'center' }}>
            <Add onClick={addRow} />
            {data.length > 1 && <Remove onClick={() => removeRow(i1)} />}
          </Grid>
        </Grid>
      ))}
    </>
  );
}

DynamicList.propTypes = {
  data: PropTypes.array.isRequired,
  // handleOnChange: PropTypes.func.isRequired,
  addRow: PropTypes.func.isRequired,
  removeRow: PropTypes.func.isRequired,
};

export default DynamicList;
