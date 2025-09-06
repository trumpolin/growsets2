import CategoryFacet from "./CategoryFacet";
import FiltersFacet from "./FiltersFacet";
import SetSummary from "@/components/SetSummary";

export default function ConfiguratorPage() {
  return (
    <div className="grid gap-4 md:grid-cols-3">
      <div className="space-y-4 md:col-span-2">
        <CategoryFacet />
        <FiltersFacet />
      </div>
      <SetSummary />
    </div>
  );
}
