

@foreach($dismantlers as $dismantler)
    <div class="german-dismantler">
        <div class="german-dismantler-gird german-dismantler-heading">
            <div class="german-dismantler-header">
                id
            </div>
            <div class="german-dismantler-header">
                hsn
            </div>
            <div class="german-dismantler-header">
                tsn
            </div>
            <div class="german-dismantler-header">
                manufacturer_plaintext
            </div>
            <div class="german-dismantler-header">
                make
            </div>
            <div class="german-dismantler-header">
                commercial_name
            </div>
            <div class="german-dismantler-header">
                date_of_allotment_of_type_code_number
            </div>
            <div class="german-dismantler-header">
                vehicle_category
            </div>
            <div class="german-dismantler-header">
                code_for_bodywork
            </div>
            <div class="german-dismantler-header">
                code_for_the_fuel_or_power_source
            </div>
            <div class="german-dismantler-header">
                max_net_power_in_kw
            </div>
            <div class="german-dismantler-header">
                engine_capacity_in_cm
            </div>
            <div class="german-dismantler-header">
                max_number_of_axles
            </div>
            <div class="german-dismantler-header">
                max_number_of_powered_axles
            </div>
            <div class="german-dismantler-header">
                max_number_of_seats
            </div>
            <div class="german-dismantler-header">
                technically_permissible_maximum_mass_in_kg
            </div>
        </div>
        <div class="german-dismantler-gird german-dismantler-content-row">
            <div class="german-dismantler-content">
                {{ $dismantler->id }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->hsn }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->tsn }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->manufacturer_plaintext }}
            </div>
            <div class="german-dismantler-content">
                {{ $dismantler->make }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->commercial_name }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->date_of_allotment_of_type_code_number }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->vehicle_category }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->code_for_bodywork }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->code_for_the_fuel_or_power_source }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->max_net_power_in_kw }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->engine_capacity_in_cm }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->max_number_of_axles }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->max_number_of_powered_axles }}
            </div>

            <div class="german-dismantler-content">
                 {{ $dismantler->max_number_of_seats }}
            </div>
            <div class="german-dismantler-content">
                 {{ $dismantler->technically_permissible_maximum_mass_in_kg }}
            </div>
        </div>
    </div>
@endforeach

<style>
    .german-dismantler-gird {
        display: grid;
        grid-template-columns: repeat(16, 20rem);
        column-gap: 1rem;
    }

    .german-dismantler-header {
        font-weight: 700;
    }

    .german-dismantler-content-row {
        padding-bottom: 2rem;
    }
</style>
