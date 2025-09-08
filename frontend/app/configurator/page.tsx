import GrowboxFacet from "./GrowboxFacet";
import LedFacet from "./LedFacet";
import ExhaustFanFacet from "./ExhaustFanFacet";
import CarbonFilterFacet from "./CarbonFilterFacet";
import DuctFacet from "./DuctFacet";
import CirculationFanFacet from "./CirculationFanFacet";
import ControllerFacet from "./ControllerFacet";
import SetSummary from "@/components/SetSummary";

export default function ConfiguratorPage() {
  return (
    <div className="grid gap-4 md:grid-cols-3">
      <div className="space-y-4 md:col-span-2">
        <GrowboxFacet />
        <LedFacet />
        <ExhaustFanFacet />
        <CarbonFilterFacet />
        <DuctFacet />
        <CirculationFanFacet />
        <ControllerFacet />
      </div>
      <SetSummary />
    </div>
  );
}
