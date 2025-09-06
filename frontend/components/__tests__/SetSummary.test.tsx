import { fireEvent, render, screen } from "@testing-library/react";
import SetSummary from "../SetSummary";
import { SelectionProvider, useSelection } from "../SelectionProvider";

function Wrapper() {
  const { setSelection } = useSelection();
  return (
    <>
      <button onClick={() => setSelection("growbox", "1")}>Select</button>
      <SetSummary />
    </>
  );
}

describe("SetSummary", () => {
  it("updates when selections change", () => {
    render(
      <SelectionProvider>
        <Wrapper />
      </SelectionProvider>,
    );

    expect(
      screen.queryAllByText((content, el) => el?.textContent === "growbox: 1")
        .length,
    ).toBe(0);
    fireEvent.click(screen.getByText("Select"));
    expect(
      screen.getAllByText((content, el) => el?.textContent === "growbox: 1")
        .length,
    ).toBeGreaterThan(0);
  });
});
