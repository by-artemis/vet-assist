import axios from 'axios';
import React, { useState } from 'react';

const CreatePetPage = () => {
  const [petData, setPetData] = useState({
    name: '',
    gender: '',
    species: '',
    breed: '',
    is_microchipped: false,
    // ... other fields from pet_details and pet_vaccines ...
  });

  const [errors, setErrors] = useState({});

  const handleChange = (event) => {
    const { name, value, type, checked } = event.target;
    setPetData((prevData) => ({
      ...prevData,
      [name]: type === 'checkbox' ? checked : value,
    }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    try {
      const response = await axios.post('/api/pets', petData); // Assuming your API route
      console.log('Pet created:', response.data);
      // You might want to redirect to a pet details page or display a success message here
    } catch (error) {
      if (error.response && error.response.status === 422) {
        setErrors(error.response.data.errors);
      } else {
        console.error('Error creating pet:', error);
        // Handle other errors gracefully
      }
    }
  };

  return (
    <div>
      <h2>Create Pet Profile</h2>
      <form onSubmit={handleSubmit}>
        {/* Input fields for pet data */}
        <div>
          <label htmlFor="name">Name:</label>
          <input
            type="text"
            id="name"
            name="name"
            value={petData.name}
            onChange={handleChange}
            required
          />
          {errors.name && <p className="error">{errors.name}</p>}
        </div>

        {/* ... other input fields for gender, species, breed, etc. */}

        <button type="submit">Create Pet</button>
      </form>
    </div>
  );
};

export default CreatePetPage;
